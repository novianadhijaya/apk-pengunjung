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

    public function get_all_ordered(): array
    {
        return $this->db
            ->order_by('year', 'ASC')
            ->order_by('month', 'ASC')
            ->get($this->table)
            ->result_array();
    }
}
