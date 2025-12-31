<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fix_visitor_data_v2 extends CI_Controller
{
    public function index()
    {
        $this->load->database();

        $updates = [
            8 => 50,
            9 => 60,
            10 => 70,
            11 => 80,
            12 => 90
        ];

        echo "<pre>";
        foreach ($updates as $m => $val) {
            $sql = "UPDATE monthly_visits SET y_total = $val WHERE year = 2025 AND month = $m";
            $this->db->query($sql);
            echo "Update Bulan $m -> $val: Affected rows = " . $this->db->affected_rows() . "\n";

            // Verify immediately
            $check = $this->db->query("SELECT y_total FROM monthly_visits WHERE year=2025 AND month=$m")->row_array();
            echo "Check DB Bulan $m: " . ($check ? $check['y_total'] : 'NULL') . "\n";
        }
        echo "</pre>";
    }
}
