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
        $filter_year = $this->input->get('filter_year', TRUE);

        if (!empty($filter_year)) {
            // Filter by selected year (Jan to Dec)
            $rows = $this->Monthly_model->get_filtered((int) $filter_year, 1, (int) $filter_year, 12);
        } else {
            // Default: Get all data
            $rows = $this->Monthly_model->get_all_ordered();
        }

        $test_month_input = $this->input->get('test_month', TRUE);
        $single_test_result = null;

        if (!empty($test_month_input)) {
            list($tm_year, $tm_month) = explode('-', $test_month_input);
            $tm_year = (int) $tm_year;
            $tm_month = (int) $tm_month;

            $train_data = $this->Monthly_model->get_data_before($tm_year, $tm_month);
            $actual_data = $this->Monthly_model->get_one($tm_year, $tm_month);

            if (count($train_data) >= 2) {
                $x_train = range(1, count($train_data));
                $y_train = array_map('intval', array_column($train_data, 'y_total'));
                $fit_train = $this->reg->fit($x_train, $y_train);

                // Predict for the next period (which is count + 1)
                $x_test = count($train_data) + 1;
                $y_pred = $this->reg->predict($fit_train['a'], $fit_train['b'], $x_test);

                $single_test_result = [
                    'month' => $test_month_input,
                    'train_count' => count($train_data),
                    'actual' => $actual_data ? (int) $actual_data['y_total'] : null,
                    'predicted' => $y_pred,
                    'error' => null,
                    'mape' => null,
                ];

                if ($single_test_result['actual'] !== null && $single_test_result['actual'] != 0) {
                    $error = abs($single_test_result['actual'] - $y_pred);
                    $single_test_result['error'] = $error;
                    $single_test_result['mape'] = ($error / $single_test_result['actual']) * 100;
                }
            }
        }

        $data = [
            'rows' => $rows,
            'fit' => null,
            'eval' => null,
            'test_month' => $test_month_input,
            'single_test' => $single_test_result,
            'available_years' => $available_years,
            'filter_year' => $filter_year,
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
