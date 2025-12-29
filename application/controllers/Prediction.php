<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Prediction extends CI_Controller
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
            'target' => null,
            'notice' => null,
            'target_month' => null,
        ];

        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $data['fit'] = $fit;

            $last = $rows[count($rows) - 1];
            $last_year = (int)$last['year'];
            $last_month = (int)$last['month'];
            $last_x = (int)$last['x_period'];

            $target_month = $this->input->get('month', TRUE);
            if (empty($target_month)) {
                $default = sprintf('%04d-%02d-01', $last_year, $last_month);
                $target_month = date('Y-m', strtotime($default . ' +1 month'));
            }

            if (!preg_match('/^\\d{4}-\\d{2}$/', $target_month)) {
                $data['notice'] = 'Format bulan tidak valid. Gunakan format YYYY-MM.';
            } else {
                list($target_year, $target_mo) = explode('-', $target_month);
                $target_year = (int)$target_year;
                $target_mo = (int)$target_mo;

                $last_index = ($last_year * 12) + $last_month;
                $target_index = ($target_year * 12) + $target_mo;
                $delta = $target_index - $last_index;

                $target_x = $last_x + $delta;
                if ($target_x < 1) {
                    $data['notice'] = 'Bulan target lebih awal dari data pertama. Prediksi tidak dihitung.';
                } else {
                    $data['target'] = [
                        'month' => $target_month,
                        'x' => $target_x,
                        'y_pred' => $this->reg->predict($fit['a'], $fit['b'], $target_x),
                    ];
                }
            }

            $data['target_month'] = $target_month;
        }

        $this->template->load('template', 'prediction/index', $data);
    }
}
