<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Master_pengunjung_model extends CI_Model
{

    public $table = 'visits';
    public $id = 'id';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL, $month = NULL)
    {
        if ($month) {
            $this->db->like('visit_date', $month);
        }
        $this->db->group_start();
        $this->db->like('id', $q);
        $this->db->or_like('visitor_name', $q);
        $this->db->or_like('institution', $q);
        $this->db->or_like('membership_type', $q);
        $this->db->or_like('member_id', $q);
        $this->db->group_end();
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $month = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        if ($month) {
            $this->db->like('visit_date', $month);
        }
        $this->db->group_start();
        $this->db->like('id', $q);
        $this->db->or_like('visitor_name', $q);
        $this->db->or_like('institution', $q);
        $this->db->or_like('membership_type', $q);
        $this->db->or_like('member_id', $q);
        $this->db->group_end();
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // get all for export with filter
    function get_all_filter($month = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        if ($month) {
            $this->db->like('visit_date', $month);
        }
        return $this->db->get($this->table)->result();
    }

    // get all for export with date range
    function get_all_filter_range($start_date, $end_date)
    {
        // Order chronologically so laporan tampil rapi dari awal ke akhir periode
        $this->db->order_by('visit_date', 'ASC');
        $this->db->order_by('visit_time', 'ASC');
        if ($start_date && $end_date) {
            $this->db->where('visit_date >=', $start_date . '-01');
            $this->db->where('visit_date <=', date('Y-m-t', strtotime($end_date . '-01')));
        }
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}
