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
        $rows = $this->Monthly_model->get_all_ordered();
        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
            'labels' => json_encode([]),
            'y_actual' => json_encode([]),
            'y_pred' => json_encode([]),
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
        }

        $this->template->load('template', 'perhitungan/index', $data);
    }
}
