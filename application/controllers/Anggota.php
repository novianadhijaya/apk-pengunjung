<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Anggota extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        // is_login(); // Uncomment if login is required
        $this->load->model('Anggota_model');
        $this->load->library('form_validation');
        $this->load->library('pagination');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = site_url('anggota/index?q=' . urlencode($q));
            $config['first_url'] = site_url('anggota/index?q=' . urlencode($q));
        } else {
            $config['base_url'] = site_url('anggota/index');
            $config['first_url'] = site_url('anggota/index');
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['query_string_segment'] = 'start';
        $config['total_rows'] = $this->Anggota_model->total_rows($q);
        $anggota = $this->Anggota_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->pagination->initialize($config);

        $data = array(
            'anggota_data' => $anggota,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template', 'anggota/tbl_anggota_list', $data);
    }

    public function read($id)
    {
        $row = $this->Anggota_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_anggota' => $row->id_anggota,
                'kode_anggota' => $row->kode_anggota,
                'nama_anggota' => $row->nama_anggota,
                'institusi' => $row->institusi,
            );
            $this->template->load('template', 'anggota/tbl_anggota_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('anggota'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('anggota/create_action'),
            'id_anggota' => set_value('id_anggota'),
            'kode_anggota' => set_value('kode_anggota'),
            'nama_anggota' => set_value('nama_anggota'),
            'institusi' => set_value('institusi'),
        );
        $this->template->load('template', 'anggota/tbl_anggota_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'kode_anggota' => $this->input->post('kode_anggota', TRUE),
                'nama_anggota' => $this->input->post('nama_anggota', TRUE),
                'institusi' => $this->input->post('institusi', TRUE),
            );

            $this->Anggota_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('anggota'));
        }
    }

    public function update($id)
    {
        $row = $this->Anggota_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('anggota/update_action'),
                'id_anggota' => set_value('id_anggota', $row->id_anggota),
                'kode_anggota' => set_value('kode_anggota', $row->kode_anggota),
                'nama_anggota' => set_value('nama_anggota', $row->nama_anggota),
                'institusi' => set_value('institusi', $row->institusi),
            );
            $this->template->load('template', 'anggota/tbl_anggota_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('anggota'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_anggota', TRUE));
        } else {
            $data = array(
                'kode_anggota' => $this->input->post('kode_anggota', TRUE),
                'nama_anggota' => $this->input->post('nama_anggota', TRUE),
                'institusi' => $this->input->post('institusi', TRUE),
            );

            $this->Anggota_model->update($this->input->post('id_anggota', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('anggota'));
        }
    }

    public function delete($id)
    {
        $row = $this->Anggota_model->get_by_id($id);

        if ($row) {
            $this->Anggota_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('anggota'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('anggota'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('kode_anggota', 'kode anggota', 'trim|required');
        $this->form_validation->set_rules('nama_anggota', 'nama anggota', 'trim|required');
        $this->form_validation->set_rules('institusi', 'institusi', 'trim|required');

        $this->form_validation->set_rules('id_anggota', 'id_anggota', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
