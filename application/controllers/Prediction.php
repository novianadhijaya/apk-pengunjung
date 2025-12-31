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
        // Default: Start = Jan Current Year, End = Dec Current Year
        // mirroring Laporan defaults
        $cur_y = date('Y');

        $start_month = $this->input->get('start_month', TRUE) ?: 1;
        $start_year = $this->input->get('start_year', TRUE) ?: $cur_y;
        $end_month = $this->input->get('end_month', TRUE) ?: 12;
        $end_year = $this->input->get('end_year', TRUE) ?: $cur_y;

        // Use filtered data for regression model building
        $rows = $this->Monthly_model->get_filtered(
            (int) $start_year,
            (int) $start_month,
            (int) $end_year,
            (int) $end_month
        );

        $data = [
            'rows' => $rows,
            'fit' => null,
            'targets' => [],
            'notice' => null,
            'start_month' => $start_month,
            'start_year' => $start_year,
            'end_month' => $end_month,
            'end_year' => $end_year,
        ];


        if (count($rows) >= 2) {
            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $data['fit'] = $fit;

            $last = $rows[count($rows) - 1];
            $last_year = (int) $last['year'];
            $last_month = (int) $last['month'];
            $last_x = (int) $last['x_period'];
            $last_index = ($last_year * 12) + $last_month;

            // Generate range
            $start_date = sprintf('%04d-%02d-01', $start_year, $start_month);
            $end_date = sprintf('%04d-%02d-01', $end_year, $end_month);

            if ($start_date > $end_date) {
                $data['notice'] = 'Periode Awal tidak boleh lebih besar dari Periode Akhir.';
            } else {
                $current = $start_date;
                while ($current <= $end_date) {
                    $curr_time = strtotime($current);
                    $m = (int) date('n', $curr_time);
                    $y_val = (int) date('Y', $curr_time);
                    $target_month_str = date('Y-m', $curr_time);

                    // Calculate X
                    $target_index = ($y_val * 12) + $m;
                    $delta = $target_index - $last_index;
                    $target_x = $last_x + $delta;

                    if ($target_x < 1) {
                        // Advance to next month
                        $current = date('Y-m-d', strtotime('+1 month', $curr_time));
                        continue;
                    }

                    // Check historical
                    $found_historical = null;
                    foreach ($rows as $row) {
                        if ((int) $row['year'] == $y_val && (int) $row['month'] == $m) {
                            $found_historical = $row;
                            break;
                        }
                    }

                    $y_actual = $found_historical ? $found_historical['y_total'] : null;
                    $final_x = $found_historical ? $found_historical['x_period'] : $target_x;

                    $data['targets'][] = [
                        'month_label' => $target_month_str,
                        'x' => $final_x,
                        'y_actual' => $y_actual,
                        'y_pred' => $this->reg->predict($fit['a'], $fit['b'], $final_x),
                    ];

                    // Advance to next month
                    $current = date('Y-m-d', strtotime('+1 month', $curr_time));
                }
            }

            // Explicitly calculate "Next Month" relative to the last data point for the top banner
            $last_row = $rows[count($rows) - 1];
            $last_x_val = (int) $last_row['x_period'];
            $last_date_str = sprintf('%04d-%02d-01', $last_row['year'], $last_row['month']);

            $next_target_x = $last_x_val + 1;
            $next_pred_val = $this->reg->predict($fit['a'], $fit['b'], $next_target_x);
            $next_month_label = date('M Y', strtotime($last_date_str . ' +1 month'));

            $data['next_month_pred'] = [
                'val' => $next_pred_val,
                'label' => $next_month_label,
                'x' => $next_target_x
            ];
        }

        $this->template->load('template', 'prediction/index', $data);
    }
}
