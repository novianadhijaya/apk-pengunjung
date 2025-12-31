<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Testing extends CI_Controller
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

        // Pass filter variables to view for re-populating the form
        $filter_start_month = $start_month;
        $filter_start_year = $start_year;
        $filter_end_month = $end_month;
        $filter_end_year = $end_year;



        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
            'available_years' => $available_years,
            'start_month' => $filter_start_month,
            'start_year' => $filter_start_year,
            'end_month' => $filter_end_month,
            'end_year' => $filter_end_year,
        ];

        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $eval = $this->reg->evaluate($y, $fit['yhat']);
            $data['fit'] = $fit;
            $data['eval'] = $eval;
        }

        $this->template->load('template', 'testing/index', $data);
    }
}
