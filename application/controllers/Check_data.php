<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Check_data extends CI_Controller
{
    public function index()
    {
        $this->load->database();
        $query = $this->db->query("SELECT * FROM monthly_visits WHERE year = 2025 AND month >= 8 ORDER BY month");
        echo json_encode($query->result_array(), JSON_PRETTY_PRINT);
    }
}
