<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Visit_model extends CI_Model
{
    public function insert(array $data): int
    {
        $this->db->insert('visits', $data);
        return (int)$this->db->insert_id();
    }

    public function update(int $id, array $data): bool
    {
        return $this->db->where('id', $id)->update('visits', $data);
    }

    public function delete(int $id): bool
    {
        return $this->db->where('id', $id)->delete('visits');
    }

    public function get(int $id)
    {
        return $this->db->get_where('visits', ['id' => $id])->row();
    }

    public function list(array $filters = [], int $limit = 50, int $offset = 0)
    {
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $this->db->group_start()
                ->like('visitor_name', $q)
                ->or_like('member_id', $q)
                ->or_like('institution', $q)
                ->or_like('room_name', $q)
                ->group_end();
        }
        if (!empty($filters['year']) && !empty($filters['month'])) {
            $ym_start = sprintf('%04d-%02d-01', (int)$filters['year'], (int)$filters['month']);
            $ym_end = date('Y-m-t', strtotime($ym_start));
            $this->db->where('visit_date >=', $ym_start);
            $this->db->where('visit_date <=', $ym_end);
        }

        return $this->db->order_by('visit_date', 'DESC')
            ->order_by('id', 'DESC')
            ->get('visits', $limit, $offset)
            ->result();
    }

    public function count(array $filters = []): int
    {
        if (!empty($filters['q'])) {
            $q = $filters['q'];
            $this->db->group_start()
                ->like('visitor_name', $q)
                ->or_like('member_id', $q)
                ->or_like('institution', $q)
                ->or_like('room_name', $q)
                ->group_end();
        }
        if (!empty($filters['year']) && !empty($filters['month'])) {
            $ym_start = sprintf('%04d-%02d-01', (int)$filters['year'], (int)$filters['month']);
            $ym_end = date('Y-m-t', strtotime($ym_start));
            $this->db->where('visit_date >=', $ym_start);
            $this->db->where('visit_date <=', $ym_end);
        }
        return (int)$this->db->count_all_results('visits');
    }

    /** Raw monthly count from visits (no preprocessing table) */
    public function monthly_counts(): array
    {
        $sql = "SELECT YEAR(visit_date) AS y, MONTH(visit_date) AS m, COUNT(*) AS total
                FROM visits
                GROUP BY YEAR(visit_date), MONTH(visit_date)
                ORDER BY YEAR(visit_date), MONTH(visit_date)";
        return $this->db->query($sql)->result_array();
    }

    /** Monthly count with basic cleaning: remove empty dates/names and duplicate rows */
    public function monthly_counts_cleaned(): array
    {
        $sql = "SELECT YEAR(visit_date) AS y, MONTH(visit_date) AS m, COUNT(*) AS total
                FROM (
                    SELECT DISTINCT member_id, visitor_name, membership_type, institution, room_name, visit_date, visit_time
                    FROM visits
                    WHERE visit_date IS NOT NULL
                      AND visit_date <> ''
                      AND visit_date <> '0000-00-00'
                      AND visitor_name IS NOT NULL
                      AND visitor_name <> ''
                ) v
                GROUP BY YEAR(visit_date), MONTH(visit_date)
                ORDER BY YEAR(visit_date), MONTH(visit_date)";
        return $this->db->query($sql)->result_array();
    }
}
