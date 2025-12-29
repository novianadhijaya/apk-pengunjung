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
        $rows = $this->Monthly_model->get_all_ordered();
        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
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
