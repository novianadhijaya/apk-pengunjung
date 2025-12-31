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
        $start_year = $this->input->get('start_year', TRUE) ?: date('Y');
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
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        // Header
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Perhitungan & Pengujian', 0, 1, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(190, 7, "Periode: $start_month/$start_year - $end_month/$end_year", 0, 1, 'C');
        $pdf->Ln(5);

        // Next Month Prediction
        $last_row = $rows[count($rows) - 1];
        $last_x = (int) $last_row['x_period'];
        $target_x = $last_x + 1;
        $next_pred = $this->reg->predict($fit['a'], $fit['b'], $target_x);
        $last_date_str = sprintf('%04d-%02d-01', $last_row['year'], $last_row['month']);
        $next_date = date('M Y', strtotime($last_date_str . ' +1 month'));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->SetFillColor(220, 220, 255); // Light blue
        $pdf->Cell(190, 10, "Prediksi Bulan Depan ($next_date): " . number_format($next_pred, 2), 1, 1, 'C', true);
        $pdf->Ln(5);

        // Charts Section
        if (!empty($chart_files)) {
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(190, 7, 'Visualisasi Grafik', 0, 1, 'L');
            $pdf->Ln(2);

            // Layout: Actual and Pred side-by-side, Compare below
            $y_start = $pdf->GetY();
            if (isset($chart_files['actual'])) {
                $pdf->Image($chart_files['actual'], 10, $y_start, 90);
            }
            if (isset($chart_files['pred'])) {
                $pdf->Image($chart_files['pred'], 105, $y_start, 90);
            }
            if (isset($chart_files['actual']) || isset($chart_files['pred'])) {
                $pdf->Ln(60); // Height of charts
            }

            if (isset($chart_files['compare'])) {
                $pdf->Image($chart_files['compare'], 10, $pdf->GetY(), 185);
                $pdf->Ln(70);
            }
        }
        $pdf->Ln(5);

        // Metrics Section
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(95, 7, 'Metrik Evaluasi', 1, 0, 'C');
        $pdf->Cell(95, 7, 'Koefisien Regresi', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(40, 6, "MAE", 1, 0);
        $pdf->Cell(55, 6, round($eval['MAE'], 4), 1, 0);
        $pdf->Cell(40, 6, "a (Intercept)", 1, 0);
        $pdf->Cell(55, 6, round($fit['a'], 6), 1, 1);

        $pdf->Cell(40, 6, "MSE", 1, 0);
        $pdf->Cell(55, 6, round($eval['MSE'], 4), 1, 0);
        $pdf->Cell(40, 6, "b (Slope)", 1, 0);
        $pdf->Cell(55, 6, round($fit['b'], 6), 1, 1);

        $pdf->Cell(40, 6, "RMSE", 1, 0);
        $pdf->Cell(55, 6, round($eval['RMSE'], 4), 1, 0);
        $pdf->Cell(95, 6, "Y = a + bX", 1, 1, 'C');

        $pdf->Cell(40, 6, "MAPE", 1, 0);
        $pdf->Cell(55, 6, round($eval['MAPE'], 2) . '%', 1, 1);

        $pdf->Cell(40, 6, "R2", 1, 0);
        $pdf->Cell(55, 6, round($eval['R2'], 4), 1, 1);

        $pdf->Ln(5);

        // Data Table
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 7, 'No', 1, 0, 'C');
        $pdf->Cell(25, 7, 'Bulan', 1, 0, 'C');
        $pdf->Cell(20, 7, 'X', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Y (Aktual)', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Y (Prediksi)', 1, 0, 'C');
        $pdf->Cell(40, 7, 'Error', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        foreach ($rows as $i => $r) {
            $y_pred = $fit['yhat'][$i];
            $error = $r['y_total'] - $y_pred;

            $pdf->Cell(10, 6, $i + 1, 1, 0, 'C');
            $pdf->Cell(25, 6, sprintf('%04d-%02d', $r['year'], $r['month']), 1, 0, 'C');
            $pdf->Cell(20, 6, $r['x_period'], 1, 0, 'C');
            $pdf->Cell(40, 6, (int) $r['y_total'], 1, 0, 'C');
            $pdf->Cell(40, 6, round($y_pred, 2), 1, 0, 'C');
            $pdf->Cell(40, 6, round($error, 2), 1, 1, 'C');
        }

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
