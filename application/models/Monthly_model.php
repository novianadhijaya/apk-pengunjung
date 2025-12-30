<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Monthly_model extends CI_Model
{
    private $table = 'monthly_visits';

    public function replace_all(array $rows): void
    {
        $this->db->truncate($this->table);
        if (empty($rows)) {
            return;
        }
        $this->db->insert_batch($this->table, $rows);
    }

    public function get_data_before(int $year, int $month): array
    {
        $target_int = ($year * 100) + $month;
        return $this->db
            ->where("(`year` * 100 + `month`) <", $target_int)
            ->order_by('year', 'ASC')
            ->order_by('month', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    public function get_one(int $year, int $month): ?array
    {
        return $this->db
            ->where('year', $year)
            ->where('month', $month)
            ->get($this->table)
            ->row_array();
    }

    public function get_filtered(int $start_year, int $start_month, int $end_year, int $end_month): array
    {
        // Calculate integer representation for comparison (YYYYMM)
        $start_int = ($start_year * 100) + $start_month;
        $end_int = ($end_year * 100) + $end_month;

        return $this->db
            ->where("(`year` * 100 + `month`) >=", $start_int)
            ->where("(`year` * 100 + `month`) <=", $end_int)
            ->order_by('year', 'ASC')
            ->order_by('month', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    public function get_all_ordered(): array
    {
        return $this->db
            ->order_by('year', 'ASC')
            ->order_by('month', 'ASC')
            ->get($this->table)
            ->result_array();
    }

    public function get_available_years(): array
    {
        return $this->db
            ->distinct()
            ->select('year')
            ->order_by('year', 'DESC')
            ->get($this->table)
            ->result_array();
    }
}
