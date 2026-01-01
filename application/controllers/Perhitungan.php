<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Perhitungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Monthly_model');
        $this->load->library('RegressionLinear', null, 'reg');
    }

    public function index()
    {
        $available_years = $this->Monthly_model->get_available_years();

        // Get filter inputs
        $start_year = $this->input->get('start_year', TRUE) ?: date('Y') - 1;
        $start_month = $this->input->get('start_month', TRUE) ?: 1;
        $end_year = $this->input->get('end_year', TRUE) ?: date('Y');
        $end_month = $this->input->get('end_month', TRUE) ?: 12;

        // Apply filter
        $rows = $this->Monthly_model->get_filtered(
            (int) $start_year,
            (int) $start_month,
            (int) $end_year,
            (int) $end_month
        );

        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
            'labels' => json_encode([]),
            'y_actual' => json_encode([]),
            'y_pred' => json_encode([]),
            'start_month' => $start_month,
            'start_year' => $start_year,
            'end_month' => $end_month,
            'end_year' => $end_year,
            'available_years' => $available_years,
        ];

        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $eval = $this->reg->evaluate($y, $fit['yhat']);

            $labels = [];
            foreach ($rows as $r) {
                $labels[] = sprintf('%04d-%02d', $r['year'], $r['month']);
            }

            $data['fit'] = $fit;
            $data['eval'] = $eval;
            $data['labels'] = json_encode($labels);
            $data['y_actual'] = json_encode($y);
            $data['y_pred'] = json_encode(array_map('floatval', $fit['yhat']));

            // Calculate Next Month Prediction based on this model
            $last_row = $rows[count($rows) - 1];
            $last_x = (int) $last_row['x_period'];
            $target_x = $last_x + 1;
            $next_pred = $this->reg->predict($fit['a'], $fit['b'], $target_x);

            // Determine label for next month
            $last_date_str = sprintf('%04d-%02d-01', $last_row['year'], $last_row['month']);
            $next_date = date('M Y', strtotime($last_date_str . ' +1 month'));

            $data['next_month_pred'] = [
                'val' => $next_pred,
                'label' => $next_date,
                'x' => $target_x
            ];
        }

        $this->template->load('template', 'perhitungan/index', $data);
    }

    public function export_excel()
    {
        $start_year = $this->input->get('start_year', TRUE) ?: date('Y');
        $start_month = $this->input->get('start_month', TRUE) ?: 1;
        $end_year = $this->input->get('end_year', TRUE) ?: date('Y');
        $end_month = $this->input->get('end_month', TRUE) ?: 12;

        $rows = $this->Monthly_model->get_filtered(
            (int) $start_year,
            (int) $start_month,
            (int) $end_year,
            (int) $end_month
        );

        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $eval = $this->reg->evaluate($y, $fit['yhat']);
        } else {
            echo "Data tidak cukup untuk perhitungan.";
            return;
        }

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Perhitungan.xls");

        echo "<table border='1'>";
        echo "<tr><th colspan='6'>Laporan Perhitungan & Pengujian</th></tr>";
        echo "<tr><th colspan='6'>Periode: $start_month/$start_year - $end_month/$end_year</th></tr>";

        // Metrics
        echo "<tr><th colspan='3'>Metrik Evaluasi</th><th colspan='3'>Rumus Regresi</th></tr>";
        echo "<tr><td>MAE</td><td>" . round($eval['MAE'], 4) . "</td><td>a (Intercept)</td><td colspan='2'>" . round($fit['a'], 6) . "</td></tr>";
        echo "<tr><td>MSE</td><td>" . round($eval['MSE'], 4) . "</td><td>b (Slope)</td><td colspan='2'>" . round($fit['b'], 6) . "</td></tr>";
        echo "<tr><td>RMSE</td><td>" . round($eval['RMSE'], 4) . "</td><td colspan='3'></td></tr>";
        echo "<tr><td>MAPE</td><td>" . round($eval['MAPE'], 2) . "%</td><td colspan='3'>Y = a + bX</td></tr>";
        echo "<tr><td>R2</td><td>" . round($eval['R2'], 4) . "</td><td colspan='3'></td></tr>";

        echo "<tr><td colspan='6'>&nbsp;</td></tr>";

        // Table Data
        echo "<tr>
                <th>No</th>
                <th>Periode</th>
                <th>Bulan</th>
                <th>X</th>
                <th>Y (Aktual)</th>
                <th>Y (Prediksi)</th>
              </tr>";

        foreach ($rows as $i => $r) {
            echo "<tr>";
            echo "<td>" . ($i + 1) . "</td>";
            echo "<td>" . sprintf('%04d-%02d', $r['year'], $r['month']) . "</td>";
            echo "<td>" . date('M Y', mktime(0, 0, 0, $r['month'], 1, $r['year'])) . "</td>";
            echo "<td>" . $r['x_period'] . "</td>";
            echo "<td>" . (int) $r['y_total'] . "</td>";
            echo "<td>" . round($fit['yhat'][$i], 2) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function export_pdf()
    {
        // Support both GET (legacy) and POST (with charts)
        $start_year = $this->input->post_get('start_year', TRUE) ?: date('Y');
        $start_month = $this->input->post_get('start_month', TRUE) ?: 1;
        $end_year = $this->input->post_get('end_year', TRUE) ?: date('Y');
        $end_month = $this->input->post_get('end_month', TRUE) ?: 12;

        $rows = $this->Monthly_model->get_filtered(
            (int) $start_year,
            (int) $start_month,
            (int) $end_year,
            (int) $end_month
        );

        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $eval = $this->reg->evaluate($y, $fit['yhat']);
        } else {
            echo "Data tidak cukup untuk perhitungan.";
            return;
        }

        // Process Charts if available
        $chart_files = [];
        $img_actual = $this->input->post('img_actual');
        $img_pred = $this->input->post('img_pred');
        $img_compare = $this->input->post('img_compare');

        if ($img_actual)
            $chart_files['actual'] = $this->save_base64_image($img_actual);
        if ($img_pred)
            $chart_files['pred'] = $this->save_base64_image($img_pred);
        if ($img_compare)
            $chart_files['compare'] = $this->save_base64_image($img_compare);

        $this->load->library('pdf');
        // Landscape agar tabel lebar tidak terpotong
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();

        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 7, 'Laporan Perhitungan & Pengujian', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(277, 7, "Periode: $start_month/$start_year - $end_month/$end_year", 0, 1, 'C');
        $pdf->Ln(5);

        // Siapkan detail per baris (prediksi & error) agar konsisten dengan tampilan web
        $detail_rows = [];
        $total_abs_error = 0;
        $total_sq_error = 0;
        $total_pct_error = 0;
        $nonZeroCount = 0;
        foreach ($rows as $i => $r) {
            $y_pred = $fit['yhat'][$i];
            $error = $r['y_total'] - $y_pred;
            $abs_error = abs($error);
            $sq_error = $error * $error;
            $pct_error = (abs($r['y_total']) > 1e-12) ? ($abs_error / $r['y_total']) * 100 : 0;

            if (abs($r['y_total']) > 1e-12) {
                $nonZeroCount++;
            }

            $total_abs_error += $abs_error;
            $total_sq_error += $sq_error;
            $total_pct_error += $pct_error;

            $detail_rows[] = [
                'year' => $r['year'],
                'month' => $r['month'],
                'x' => $r['x_period'],
                'y' => $r['y_total'],
                'y_pred' => $y_pred,
                'error' => $error,
                'abs_error' => $abs_error,
                'sq_error' => $sq_error,
                'pct_error' => $pct_error,
            ];
        }

        // Next Month Prediction
        $last_row = $rows[count($rows) - 1];
        $last_x = (int) $last_row['x_period'];
        $target_x = $last_x + 1;
        $next_pred = $this->reg->predict($fit['a'], $fit['b'], $target_x);
        $last_date_str = sprintf('%04d-%02d-01', $last_row['year'], $last_row['month']);
        $next_date = date('M Y', strtotime($last_date_str . ' +1 month'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(220, 220, 255); // Light blue
        $pdf->Cell(277, 10, "Prediksi Bulan Depan ($next_date): " . number_format($next_pred, 2), 1, 1, 'C', true);
        $pdf->Ln(5);

        // Charts Section
        if (!empty($chart_files)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(277, 7, 'Visualisasi Grafik', 0, 1, 'L');
            $pdf->Ln(2);

            // Layout: Actual and Pred side-by-side, Compare below
            $y_start = $pdf->GetY();
            if (isset($chart_files['actual'])) {
                $pdf->Image($chart_files['actual'], 10, $y_start, 130);
            }
            if (isset($chart_files['pred'])) {
                $pdf->Image($chart_files['pred'], 150, $y_start, 130);
            }
            $pdf->Ln(70); // height after two charts

            if (isset($chart_files['compare'])) {
                $pdf->Image($chart_files['compare'], 10, $pdf->GetY(), 260);
                $pdf->Ln(90);
            }
        }
        $pdf->Ln(5);

        // Perhitungan Prediksi (detail, ASCII supaya jelas di PDF)
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(277, 7, 'Perhitungan Prediksi (Regresi Linier)', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(35, 7, 'Sum X', 1, 0, 'L');   $pdf->Cell(40, 7, round($fit['sum_x'], 6), 1, 0, 'R');
        $pdf->Cell(35, 7, 'Sum Y', 1, 0, 'L');   $pdf->Cell(40, 7, round($fit['sum_y'], 6), 1, 0, 'R');
        $pdf->Cell(35, 7, 'Sum X2', 1, 0, 'L');  $pdf->Cell(92, 7, round($fit['sum_x2'], 6), 1, 1, 'R');
        $pdf->Cell(35, 7, 'Sum XY', 1, 0, 'L');  $pdf->Cell(40, 7, round($fit['sum_xy'], 6), 1, 0, 'R');
        $pdf->Cell(35, 7, 'n', 1, 0, 'L');       $pdf->Cell(40, 7, $fit['n'], 1, 0, 'R');
        $pdf->Cell(35, 7, 'Persamaan', 1, 0, 'L'); $pdf->Cell(92, 7, "Y' = a + bX", 1, 1, 'L');
        $pdf->Cell(35, 7, 'a (Intercept)', 1, 0, 'L'); $pdf->Cell(40, 7, round($fit['a'], 6), 1, 0, 'R');
        $pdf->Cell(35, 7, 'b (Slope)', 1, 0, 'L');     $pdf->Cell(40, 7, round($fit['b'], 6), 1, 0, 'R');
        $pdf->Cell(35, 7, "Rumus Y'", 1, 0, 'L');      $pdf->Cell(92, 7, "a + bX", 1, 1, 'L');
        $pdf->Ln(2);

        $n = $fit['n'];
        $den = ($n * $fit['sum_x2']) - ($fit['sum_x'] * $fit['sum_x']);
        $numB = ($n * $fit['sum_xy']) - ($fit['sum_x'] * $fit['sum_y']);
        $numA = ($fit['sum_y'] * $fit['sum_x2']) - ($fit['sum_x'] * $fit['sum_xy']);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(277, 5,
            "b = (n*SumXY - SumX*SumY) / (n*SumX2 - (SumX)^2) = ($n * " . round($fit['sum_xy'], 4) . " - " . round($fit['sum_x'], 4) . " * " . round($fit['sum_y'], 4) . ") / ($n * " . round($fit['sum_x2'], 4) . " - (" . round($fit['sum_x'], 4) . ")^2) = " . round($numB, 6) . " / " . round($den, 6) . " = " . round($fit['b'], 6)
            . "\na = (SumY*SumX2 - SumX*SumXY) / (n*SumX2 - (SumX)^2) = (" . round($fit['sum_y'], 4) . " * " . round($fit['sum_x2'], 4) . " - " . round($fit['sum_x'], 4) . " * " . round($fit['sum_xy'], 4) . ") / " . round($den, 6) . " = " . round($numA, 6) . " / " . round($den, 6) . " = " . round($fit['a'], 6)
        , 0, 'L');
        $pdf->Ln(2);

        // Contoh Y' untuk X terakhir dan prediksi berikut
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(277, 5, "Y' untuk X terakhir (" . $last_x . ") = " . round($fit['a'], 6) . " + (" . round($fit['b'], 6) . " * " . $last_x . ") = " . round($fit['a'] + ($fit['b'] * $last_x), 4), 0, 1);
        $pdf->Cell(277, 5, "Prediksi bulan depan (" . $next_date . ", X=" . $target_x . "): " . round($next_pred, 4), 0, 1);
        $target_year_x = $target_x + 11;
        $next_year_pred = $this->reg->predict($fit['a'], $fit['b'], $target_year_x);
        $next_year_date = date('M Y', strtotime($last_date_str . ' +12 months'));
        $pdf->Cell(277, 5, "Prediksi 12 bulan berikutnya (" . $next_year_date . ", X=" . $target_year_x . "): " . round($next_year_pred, 4), 0, 1);
        $pdf->Ln(3);
        // Perhitungan Pengujian (judul)
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(277, 7, 'Perhitungan Pengujian', 0, 1, 'L');

        // Metrics Section (ringkas + notasi)
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(138.5, 7, 'Metrik Evaluasi', 1, 0, 'C');
        $pdf->Cell(138.5, 7, 'Koefisien Regresi', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 6, "MAE", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['MAE'], 4), 1, 0);
        $pdf->Cell(60, 6, "a (Intercept)", 1, 0);
        $pdf->Cell(78.5, 6, round($fit['a'], 6), 1, 1);

        $pdf->Cell(60, 6, "MSE", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['MSE'], 4), 1, 0);
        $pdf->Cell(60, 6, "b (Slope)", 1, 0);
        $pdf->Cell(78.5, 6, round($fit['b'], 6), 1, 1);

        $pdf->Cell(60, 6, "RMSE", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['RMSE'], 4), 1, 0);
        $pdf->Cell(138.5, 6, "Y = a + bX", 1, 1, 'C');

        $pdf->Cell(60, 6, "MAPE", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['MAPE'], 2) . '%', 1, 0);
        $pdf->Cell(60, 6, "R2", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['R2'], 4), 1, 1);

        $pdf->Cell(60, 6, "MAPE Cat.", 1, 0);
        $pdf->Cell(78.5, 6, $eval['cat_mape'], 1, 0);
        $pdf->Cell(60, 6, "SD(Y) Populasi", 1, 0);
        $pdf->Cell(78.5, 6, round($eval['sd_pop'], 4), 1, 1);

        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(277, 5, "n=" . $fit['n'] . " | k (Y!=0)=" . $nonZeroCount . " | Sum|e|=" . round($total_abs_error, 4), 0, 1);
        $pdf->Cell(277, 5, "Sum e2 (SSE)=" . round($eval['SSE'], 4) . " | SST=" . round($eval['SST'], 4), 0, 1);
        $pdf->Ln(3);

        // Data Table (dengan Y', error, |e|, e2, %error)
        // Table header helper (repeat on page break)
        $renderTableHeader = function () use (&$pdf) {
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->Cell(12, 7, 'No', 1, 0, 'C');
            $pdf->Cell(32, 7, 'Bulan', 1, 0, 'C');
            $pdf->Cell(15, 7, 'X', 1, 0, 'C');
            $pdf->Cell(22, 7, 'Y', 1, 0, 'C');
            $pdf->Cell(22, 7, "Y'", 1, 0, 'C');
            $pdf->Cell(25, 7, 'Error', 1, 0, 'C');
            $pdf->Cell(25, 7, '|e|', 1, 0, 'C');
            $pdf->Cell(25, 7, 'e2', 1, 0, 'C');
            $pdf->Cell(20, 7, '%err', 1, 1, 'C');
            $pdf->SetFont('Arial', '', 10);
        };

        // Mulai tabel di halaman baru bila posisi sudah terlalu bawah
        if ($pdf->GetY() > 200) {
            $pdf->AddPage();
        }
        $renderTableHeader();

        foreach ($detail_rows as $i => $r) {
            // Manually handle page break to avoid row terpotong
            if ($pdf->GetY() > 250) { // near bottom of A4 with default margins
                $pdf->AddPage();
                $renderTableHeader();
            }

            $pdf->Cell(12, 6, $i + 1, 1, 0, 'C');
            $pdf->Cell(32, 6, sprintf('%04d-%02d', $r['year'], $r['month']), 1, 0, 'C');
            $pdf->Cell(15, 6, $r['x'], 1, 0, 'C');
            $pdf->Cell(22, 6, (int) $r['y'], 1, 0, 'C');
            $pdf->Cell(22, 6, round($r['y_pred'], 2), 1, 0, 'C');
            $pdf->Cell(25, 6, round($r['error'], 2), 1, 0, 'C');
            $pdf->Cell(25, 6, round($r['abs_error'], 2), 1, 0, 'C');
            $pdf->Cell(25, 6, round($r['sq_error'], 2), 1, 0, 'C');
            $pdf->Cell(20, 6, round($r['pct_error'], 2) . '%', 1, 1, 'C');
        }
        // Pastikan masih ada ruang untuk total, kalau tidak bikin halaman baru
        if ($pdf->GetY() > 250) {
            $pdf->AddPage();
            $renderTableHeader();
        }
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(128, 7, 'Total', 1, 0, 'C');
        $pdf->Cell(25, 7, round($total_abs_error, 2), 1, 0, 'C');
        $pdf->Cell(25, 7, round($total_sq_error, 2), 1, 0, 'C');
        $pdf->Cell(20, 7, round($total_pct_error, 2) . '%', 1, 1, 'C');

        // Ringkasan metrik dipindah ke bawah (setelah tabel)
        $pdf->Ln(6);
        $box_w = 88;
        $gap = 4;
        $y = $pdf->GetY();
        $x0 = 10;

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(277, 6, 'Ringkasan Metrik', 0, 1, 'L');
        $pdf->SetFont('Arial', '', 9);

        // Box MAE
        $pdf->SetFillColor(220, 80, 70);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY($x0, $y + 6);
        $pdf->Cell($box_w, 20, '', 1, 0, 'L', true);
        $pdf->SetXY($x0 + 2, $y + 9);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($box_w - 4, 5, 'MAE', 0, 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($box_w - 4, 4, "Sum|e| / n = " . round($total_abs_error, 2) . " / " . $fit['n'], 0, 2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($box_w - 4, 4, "= " . round($eval['MAE'], 4), 0, 0);

        // Box MSE
        $x1 = $x0 + $box_w + $gap;
        $pdf->SetFillColor(220, 80, 70);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY($x1, $y + 6);
        $pdf->Cell($box_w, 20, '', 1, 0, 'L', true);
        $pdf->SetXY($x1 + 2, $y + 9);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($box_w - 4, 5, 'MSE', 0, 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($box_w - 4, 4, "Sum e2 / n = " . round($total_sq_error, 2) . " / " . $fit['n'], 0, 2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($box_w - 4, 4, "= " . round($eval['MSE'], 4), 0, 0);

        // Box MAPE
        $x2 = $x1 + $box_w + $gap;
        $pdf->SetFillColor(0, 166, 90);
        $pdf->SetTextColor(255, 255, 255);
        $pdf->SetXY($x2, $y + 6);
        $pdf->Cell($box_w, 20, '', 1, 0, 'L', true);
        $pdf->SetXY($x2 + 2, $y + 9);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell($box_w - 4, 5, 'MAPE', 0, 2);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell($box_w - 4, 4, "Sum %Err / n = " . round($total_pct_error, 2) . " / " . $fit['n'], 0, 2);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell($box_w - 4, 4, "= " . round($eval['MAPE'], 2) . "% (" . $eval['cat_mape'] . ")", 0, 0);

        // Reset style
        $pdf->SetTextColor(0, 0, 0);

        $pdf->Output();

        // Cleanup
        foreach ($chart_files as $file) {
            if (file_exists($file))
                unlink($file);
        }
    }

    private function save_base64_image($base64_string)
    {
        $data = explode(',', $base64_string);
        // data[0] is data:image/png;base64, data[1] is the raw base64
        if (count($data) < 2)
            return null;

        $content = base64_decode($data[1]);
        $filename = sys_get_temp_dir() . '/chart_' . uniqid() . '.png';
        file_put_contents($filename, $content);
        return $filename;
    }
}





