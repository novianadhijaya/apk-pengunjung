<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('RegressionLinear', null, 'reg');
    }

    public function get_total_visits(): int
    {
        return (int)$this->db->count_all('visits');
    }

    public function get_average_visits(): float
    {
        $row = $this->db->select('COUNT(*) AS total, MIN(visit_date) AS min_date, MAX(visit_date) AS max_date')
            ->get('visits')
            ->row();

        if (!$row || empty($row->min_date) || empty($row->max_date)) {
            return 0;
        }

        $min = strtotime($row->min_date);
        $max = strtotime($row->max_date);
        $days = max(1, (int)floor(($max - $min) / 86400) + 1);
        $avg = ((int)$row->total) / $days;
        return round($avg, 1);
    }

    public function get_visits_last_12_months(): array
    {
        $stats = $this->db->query(
            "SELECT YEAR(visit_date) AS y, MONTH(visit_date) AS m, COUNT(*) AS total
             FROM visits
             GROUP BY YEAR(visit_date), MONTH(visit_date)
             ORDER BY YEAR(visit_date), MONTH(visit_date)"
        )->result();

        $map = [];
        foreach ($stats as $row) {
            $key = sprintf('%04d-%02d', $row->y, $row->m);
            $map[$key] = (int)$row->total;
        }

        $result = [];
        $current = new DateTime(date('Y-m-01'));
        for ($i = 11; $i >= 0; $i--) {
            $dt = clone $current;
            $dt->modify('-' . $i . ' months');
            $key = $dt->format('Y-m');
            $result[] = (object)[
                'label' => $key,
                'count' => $map[$key] ?? 0,
            ];
        }

        return $result;
    }

    public function get_recent_visits(int $limit = 5): array
    {
        return $this->db->order_by('visit_date', 'DESC')
            ->order_by('id', 'DESC')
            ->get('visits', $limit)
            ->result();
    }

    public function get_visitor_types(): array
    {
        $sql = "SELECT membership_type, COUNT(*) AS count
                FROM visits
                GROUP BY membership_type";
        return $this->db->query($sql)->result();
    }

    public function predict_next_month(): float
    {
        try {
            if (!$this->db->table_exists('monthly_visits')) {
                return 0;
            }

            $rows = $this->db->order_by('year', 'ASC')
                ->order_by('month', 'ASC')
                ->get('monthly_visits')
                ->result_array();

            if (count($rows) < 2) {
                return 0;
            }

            $x = array_column($rows, 'x_period');
            $y = array_map('intval', array_column($rows, 'y_total'));
            $fit = $this->reg->fit($x, $y);
            $target_x = max($x) + 1;
            return $this->reg->predict($fit['a'], $fit['b'], $target_x);
        } catch (Exception $e) {
            return 0;
        }
    }
}
