<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        is_login();
        // $this->load->model('Dashboard_model');

    }

    public function index()
    {
        $this->load->model('Dashboard_model');
        $this->load->model('Master_pengunjung_model');
        $this->load->model('Anggota_model');
        $this->load->model('Tbl_profil_apps_model');

        $data = array(
            'total_visits' => $this->Dashboard_model->get_total_visits(),
            'avg_visits' => $this->Dashboard_model->get_average_visits(),
            'monthly_stats' => $this->Dashboard_model->get_visits_last_12_months(),
            'prediction_next_month' => $this->Dashboard_model->predict_next_month(),
            'recent_visits' => $this->Dashboard_model->get_recent_visits(),
            'visitor_types' => $this->Dashboard_model->get_visitor_types(),
            'total_anggota' => $this->Anggota_model->total_rows(),
            'app_info' => $this->Tbl_profil_apps_model->get_by_id(1)
        );

        $this->template->load('template', 'dashboard', $data);
    }


}
