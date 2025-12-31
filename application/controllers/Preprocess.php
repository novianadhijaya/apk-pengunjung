<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Preprocess extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Visit_model');
        $this->load->model('Monthly_model');
    }

    public function index()
    {
        $data = [
            'monthly' => $this->Monthly_model->get_all_ordered(),
        ];
        $this->template->load('template', 'preprocess/index', $data);
    }

    public function run()
    {
        $raw = $this->Visit_model->monthly_counts_cleaned();
        $rows = [];
        $x = 1;
        foreach ($raw as $r) {
            $rows[] = [
                'year' => (int) $r['y'],
                'month' => (int) $r['m'],
                'y_total' => (int) $r['total'],
                'x_period' => $x,
            ];
            $x++;
        }

        $this->Monthly_model->replace_all($rows);
        $this->session->set_flashdata('message', 'Preprocessing selesai.');
        redirect(site_url('preprocess'));
    }
}
