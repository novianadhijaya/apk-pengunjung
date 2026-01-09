<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_pengunjung extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login(); // Uncomment if login is required
        $this->load->model('Master_pengunjung_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $month = $this->input->get('month', TRUE);
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = site_url('master_pengunjung/index?q=' . urlencode($q) . '&month=' . $month);
            $config['first_url'] = site_url('master_pengunjung/index?q=' . urlencode($q) . '&month=' . $month);
        } else {
            $config['base_url'] = site_url('master_pengunjung/index?month=' . $month);
            $config['first_url'] = site_url('master_pengunjung/index?month=' . $month);
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Master_pengunjung_model->total_rows($q, $month);
        $pengunjung = $this->Master_pengunjung_model->get_limit_data($config['per_page'], $start, $q, $month);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);

        $data = array(
            'pengunjung_data' => $pengunjung,
            'q' => $q,
            'month' => $month,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'master_pengunjung/list', $data);
    }

    public function excel()
    {
        $month = $this->input->get('month', TRUE);
        $data = $this->Master_pengunjung_model->get_all_filter($month);

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data_Pengunjung.xls");

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
        foreach ($data as $row) {
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

    public function pdf()
    {
        $month = $this->input->get('month', TRUE);
        $data = $this->Master_pengunjung_model->get_all_filter($month);

        $this->load->library('pdf');
        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(277, 7, 'Laporan Data Pengunjung', 0, 1, 'C');
        $pdf->SetFont('Arial', 'B', 12);
        if ($month) {
            $pdf->Cell(277, 7, 'Periode: ' . $month, 0, 1, 'C');
        }
        $pdf->Cell(10, 7, '', 0, 1);

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(10, 6, 'No', 1, 0, 'C');
        $pdf->Cell(45, 6, 'Tanggal', 1, 0, 'C'); // Increased from 30
        $pdf->Cell(25, 6, 'Jam', 1, 0, 'C');
        $pdf->Cell(50, 6, 'Nama', 1, 0, 'C'); // Decreased from 60
        $pdf->Cell(60, 6, 'Institusi', 1, 0, 'C');
        $pdf->Cell(35, 6, 'Tipe', 1, 0, 'C'); // Decreased from 40
        $pdf->Cell(50, 6, 'Tujuan', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(45, 6, tgl_indo($row->visit_date), 1, 0); // Match header
            $pdf->Cell(25, 6, $row->visit_time, 1, 0, 'C');
            $pdf->Cell(50, 6, substr($row->visitor_name, 0, 30), 1, 0); // Match header
            $pdf->Cell(60, 6, substr($row->institution, 0, 30), 1, 0);
            $pdf->Cell(35, 6, $row->membership_type, 1, 0); // Match header
            $pdf->Cell(50, 6, substr($row->room_name, 0, 25), 1, 1);
        }

        $pdf->Output();
    }

    public function read($id)
    {
        $row = $this->Master_pengunjung_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'visitor_name' => $row->visitor_name,
                'institution' => $row->institution,
                'membership_type' => $row->membership_type,
                'member_id' => $row->member_id,
                'room_name' => $row->room_name,
                'visit_date' => $row->visit_date,
                'visit_time' => $row->visit_time,
            );
            $this->template->load('template', 'master_pengunjung/read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_pengunjung'));
        }
    }

    public function delete($id)
    {
        $row = $this->Master_pengunjung_model->get_by_id($id);

        if ($row) {
            $this->Master_pengunjung_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('master_pengunjung'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('master_pengunjung'));
        }
    }

}
