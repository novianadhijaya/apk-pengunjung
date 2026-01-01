<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Master_pengunjung_model');
        $this->load->model('Monthly_model');
        $this->load->library('RegressionLinear', null, 'reg');
    }

    public function index()
    {
        $this->template->load('template', 'laporan/index');
    }

    public function pengunjung()
    {
        $rows = $this->get_pengunjung_data();
        $data = [
            'rows' => $rows,
            'start_month' => $this->input->get('start_month', TRUE) ?: 1,
            'start_year' => $this->input->get('start_year', TRUE) ?: date('Y') - 1,
            'end_month' => $this->input->get('end_month', TRUE) ?: 12,
            'end_year' => $this->input->get('end_year', TRUE) ?: date('Y'),
        ];
        $this->template->load('template', 'laporan/pengunjung', $data);
    }

    private function get_pengunjung_data()
    {
        $start_year = $this->input->get('start_year', TRUE) ?: date('Y') - 1;
        $start_month = $this->input->get('start_month', TRUE) ?: 1;
        $end_year = $this->input->get('end_year', TRUE) ?: date('Y');
        $end_month = $this->input->get('end_month', TRUE) ?: 12;

        $start = sprintf('%04d-%02d', $start_year, $start_month);
        $end = sprintf('%04d-%02d', $end_year, $end_month);

        return $this->Master_pengunjung_model->get_all_filter_range($start, $end);
    }

    private function get_monthly_data_filtered()
    {
        $start_year = $this->input->get('start_year', TRUE) ?: date('Y') - 1;
        $start_month = $this->input->get('start_month', TRUE) ?: 1;
        $end_year = $this->input->get('end_year', TRUE) ?: date('Y');
        $end_month = $this->input->get('end_month', TRUE) ?: 12;

        return $this->Monthly_model->get_filtered(
            (int) $start_year,
            (int) $start_month,
            (int) $end_year,
            (int) $end_month
        );
    }

    public function pengunjung_excel()
    {
        $rows = $this->get_pengunjung_data();

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Data_Pengunjung.xls");

        echo "<table border='1'>";
        echo "<tr>";
        echo "<th width='30'>No</th>";
        echo "<th width='150'>Tanggal</th>";
        echo "<th width='80'>Jam</th>";
        echo "<th width='200'>Nama Pengunjung</th>";
        echo "<th width='200'>Institusi</th>";
        echo "<th width='100'>Tipe</th>";
        echo "<th width='150'>Tujuan</th>";
        echo "</tr>";

        $no = 1;
        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td>" . $no++ . "</td>";
            echo "<td>" . tgl_indo($row->visit_date) . "</td>";
            echo "<td>" . $row->visit_time . "</td>";
            echo "<td>" . $row->visitor_name . "</td>";
            echo "<td>" . $row->institution . "</td>";
            echo "<td>" . $row->membership_type . "</td>";
            echo "<td>" . $row->room_name . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }

    public function pengunjung_pdf()
    {
        $rows = $this->get_pengunjung_data();
        $month_label = "Filter Periode"; // Simplify label for now or reconstruct from params

        $this->load->library('pdf');
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 7, 'Laporan Data Pengunjung', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);

        $pdf->Cell(277, 7, $month_label, 0, 1, 'C');

        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(25, 6, 'Jam', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Institusi', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Tipe', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Tujuan', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($rows as $row) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(45, 6, tgl_indo($row->visit_date), 1, 0);
            $pdf->Cell(25, 6, $row->visit_time, 1, 0, 'C');
            $pdf->Cell(50, 6, substr($row->visitor_name, 0, 30), 1, 0);
            $pdf->Cell(60, 6, substr($row->institution, 0, 30), 1, 0);
            $pdf->Cell(35, 6, $row->membership_type, 1, 0);
            $pdf->Cell(50, 6, substr($row->room_name, 0, 25), 1, 1);
        }

        $pdf->Output();
    }

    public function prediksi()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_prediksi_data($rows, $this->input->get('target_month', TRUE));

        $data['start_month'] = $this->input->get('start_month', TRUE) ?: 1;
        $data['start_year'] = $this->input->get('start_year', TRUE) ?: date('Y') - 1;
        $data['end_month'] = $this->input->get('end_month', TRUE) ?: 12;
        $data['end_year'] = $this->input->get('end_year', TRUE) ?: date('Y');

        $this->template->load('template', 'laporan/prediksi', $data);
    }

    public function prediksi_excel()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_prediksi_data($rows, $this->input->get('target_month', TRUE));

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Hasil_Prediksi.xls");

        if (!$data['fit']) {
            echo "Data preprocessing belum ada atau kurang dari 2 bulan.";
            return;
        }

        echo "<table border='1'>";
        echo "<tr><th colspan='4'>Laporan Hasil Prediksi</th></tr>";
        if (!empty($data['forecasts'])) {
            // Remove top block
        }
        echo "<tr><td colspan='4'>a=" . round($data['fit']['a'], 6) . " | b=" . round($data['fit']['b'], 6) . "</td></tr>";
        echo "<tr><th>X</th><th>Bulan</th><th>Y</th><th>Yhat</th></tr>";

        foreach ($data['rows'] as $i => $r) {
            echo "<tr>";
            echo "<td>" . $r['x_period'] . "</td>";
            echo "<td>" . sprintf('%04d-%02d', $r['year'], $r['month']) . "</td>";
            echo "<td>" . (int) $r['y_total'] . "</td>";
            echo "<td>" . round($data['fit']['yhat'][$i], 2) . "</td>";
            echo "</tr>";
        }

        if (!empty($data['forecasts'])) {
            foreach ($data['forecasts'] as $f) {
                echo "<tr style='background-color: #c9f7f5;'>";
                echo "<td>" . $f['x'] . "</td>";
                echo "<td>" . $f['month'] . " (Prediksi)</td>";
                echo "<td>-</td>";
                echo "<td>" . round($f['y_pred'], 2) . "</td>";
                echo "</tr>";
            }
        }
        echo "</table>";
    }

    public function prediksi_pdf()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_prediksi_data($rows, $this->input->get('target_month', TRUE));

        $this->load->library('pdf');
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 7, 'Laporan Hasil Prediksi', 0, 1, 'C');
        if (!$data['fit']) {
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(277, 7, 'Data preprocessing belum ada atau kurang dari 2 bulan.', 0, 1, 'C');
            $pdf->Output();
            return;
        }
        $pdf->SetFont('Arial', '', 11);
        if (!empty($data['forecasts'])) {
            // Remove top block
        }
        $pdf->Cell(10, 6, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(30, 6, 'a', 1, 0, 'C');
        $pdf->Cell(30, 6, 'b', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Sum X', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Sum Y', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Sum X2', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Sum XY', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 6, round($data['fit']['a'], 6), 1, 0, 'C');
        $pdf->Cell(30, 6, round($data['fit']['b'], 6), 1, 0, 'C');
        $pdf->Cell(40, 6, $data['fit']['sum_x'], 1, 0, 'C');
        $pdf->Cell(40, 6, $data['fit']['sum_y'], 1, 0, 'C');
        $pdf->Cell(40, 6, $data['fit']['sum_x2'], 1, 0, 'C');
        $pdf->Cell(40, 6, $data['fit']['sum_xy'], 1, 1, 'C');

        $pdf->Cell(10, 6, '', 0, 1);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(20, 6, 'X', 1, 0, 'C');
        $pdf->Cell(40, 6, 'Bulan', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Y', 1, 0, 'C');
        $pdf->Cell(30, 6, 'Yhat', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        foreach ($data['rows'] as $i => $r) {
            $pdf->Cell(20, 6, $r['x_period'], 1, 0, 'C');
            $pdf->Cell(40, 6, sprintf('%04d-%02d', $r['year'], $r['month']), 1, 0, 'C');
            $pdf->Cell(30, 6, (int) $r['y_total'], 1, 0, 'C');
            $pdf->Cell(30, 6, round($data['fit']['yhat'][$i], 2), 1, 1, 'C');
        }

        if (!empty($data['forecasts'])) {
            $pdf->SetFillColor(200, 255, 200);
            foreach ($data['forecasts'] as $f) {
                $pdf->Cell(20, 6, $f['x'], 1, 0, 'C', true);
                $pdf->Cell(40, 6, $f['month'] . ' (Pred)', 1, 0, 'C', true);
                $pdf->Cell(30, 6, '-', 1, 0, 'C', true);
                $pdf->Cell(30, 6, round($f['y_pred'], 2), 1, 1, 'C', true);
            }
        }

        $pdf->Output();
    }

    public function pengujian()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_pengujian_data($rows);

        $data['start_month'] = $this->input->get('start_month', TRUE) ?: 1;
        $data['start_year'] = $this->input->get('start_year', TRUE) ?: date('Y') - 1;
        $data['end_month'] = $this->input->get('end_month', TRUE) ?: 12;
        $data['end_year'] = $this->input->get('end_year', TRUE) ?: date('Y');

        $this->template->load('template', 'laporan/pengujian', $data);
    }

    public function pengujian_excel()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_pengujian_data($rows);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Laporan_Pengujian.xls");

        if (!$data['eval']) {
            echo "Data preprocessing belum ada atau kurang dari 2 bulan.";
            return;
        }

        echo "<table border='1'>";
        echo "<tr><th colspan='2'>Laporan Pengujian</th></tr>";
        echo "<tr><th>R2</th><td>" . round($data['eval']['R2'], 6) . "</td></tr>";
        echo "<tr><th>MAE</th><td>" . round($data['eval']['MAE'], 6) . "</td></tr>";
        echo "<tr><th>MSE</th><td>" . round($data['eval']['MSE'], 6) . "</td></tr>";
        echo "<tr><th>RMSE</th><td>" . round($data['eval']['RMSE'], 6) . "</td></tr>";
        echo "<tr><th>MAPE</th><td>" . round($data['eval']['MAPE'], 2) . "% (" . $data['eval']['cat_mape'] . ")</td></tr>";
        echo "<tr><th>SD(Y) Pop</th><td>" . round($data['eval']['sd_pop'], 6) . "</td></tr>";
        echo "<tr><th>Kategori SD</th><td>" . $data['eval']['cat_sd'] . "</td></tr>";
        echo "<tr><th>SST</th><td>" . round($data['eval']['SST'], 6) . "</td></tr>";
        echo "<tr><th>SSR</th><td>" . round($data['eval']['SSR'], 6) . "</td></tr>";
        echo "<tr><th>SSE</th><td>" . round($data['eval']['SSE'], 6) . "</td></tr>";
        echo "</table>";
    }

    public function pengujian_pdf()
    {
        $rows = $this->get_monthly_data_filtered();
        $data = $this->build_pengujian_data($rows);

        $this->load->library('pdf');
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan Pengujian', 0, 1, 'C');
        if (!$data['eval']) {
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(190, 7, 'Data preprocessing belum ada atau kurang dari 2 bulan.', 0, 1, 'C');
            $pdf->Output();
            return;
        }
        $pdf->Cell(10, 6, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(60, 6, 'Metrik', 1, 0, 'C');
        $pdf->Cell(60, 6, 'Nilai', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(60, 6, 'R2', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['R2'], 6), 1, 1);
        $pdf->Cell(60, 6, 'MAE', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['MAE'], 6), 1, 1);
        $pdf->Cell(60, 6, 'MSE', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['MSE'], 6), 1, 1);
        $pdf->Cell(60, 6, 'RMSE', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['RMSE'], 6), 1, 1);
        $pdf->Cell(60, 6, 'MAPE', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['MAPE'], 2) . '% (' . $data['eval']['cat_mape'] . ')', 1, 1);
        $pdf->Cell(60, 6, 'SD(Y) Pop', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['sd_pop'], 6), 1, 1);
        $pdf->Cell(60, 6, 'Kategori SD', 1, 0);
        $pdf->Cell(60, 6, $data['eval']['cat_sd'], 1, 1);
        $pdf->Cell(60, 6, 'SST', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['SST'], 6), 1, 1);
        $pdf->Cell(60, 6, 'SSR', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['SSR'], 6), 1, 1);
        $pdf->Cell(60, 6, 'SSE', 1, 0);
        $pdf->Cell(60, 6, round($data['eval']['SSE'], 6), 1, 1);

        $pdf->Output();
    }

    private function build_prediksi_data(array $rows, ?string $target_month): array
    {
        $data = [
            'rows' => $rows,
            'fit' => null,
            'forecasts' => [],
            'notice' => null,
            'target_month' => $target_month,
        ];

        if (count($rows) < 2) {
            return $data;
        }

        $x = array_column($rows, 'x_period');
        $y = array_map('intval', array_column($rows, 'y_total'));
        $fit = $this->reg->fit($x, $y);
        $data['fit'] = $fit;

        $last = $rows[count($rows) - 1];
        $last_year = (int) $last['year'];
        $last_month = (int) $last['month'];
        $last_x = (int) $last['x_period'];

        // Determine range to predict
        // Start: Next month after last data
        // End: December 2026 (as requested) or target_month if specified greater than Dec 2026?
        // Defaulting to Dec 2026.
        $target_year = 2026;
        $target_mo = 12;

        $start_ts = strtotime(sprintf('%04d-%02d-01', $last_year, $last_month) . ' +1 month');
        $end_ts = strtotime(sprintf('%04d-%02d-01', $target_year, $target_mo));
        
        // If data already goes beyond Dec 2026, just predict 12 months ahead
        if ($start_ts > $end_ts) {
            $end_ts = strtotime('+12 months', $start_ts);
        }

        $curr_ts = $start_ts;
        $curr_x = $last_x + 1;

        while ($curr_ts <= $end_ts) {
            $label = date('Y-m', $curr_ts);
            $y_pred = $this->reg->predict($fit['a'], $fit['b'], $curr_x);
            
            $data['forecasts'][] = [
                'month' => $label,
                'x' => $curr_x,
                'y_pred' => $y_pred
            ];

            $curr_ts = strtotime('+1 month', $curr_ts);
            $curr_x++;
        }

        return $data;
    }

    private function build_pengujian_data(array $rows): array
    {
        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
        ];

        if (count($rows) < 2) {
            return $data;
        }

        $x = array_column($rows, 'x_period');
        $y = array_map('intval', array_column($rows, 'y_total'));
        $fit = $this->reg->fit($x, $y);
        $eval = $this->reg->evaluate($y, $fit['yhat']);
        $data['fit'] = $fit;
        $data['eval'] = $eval;
        return $data;
    }
}
