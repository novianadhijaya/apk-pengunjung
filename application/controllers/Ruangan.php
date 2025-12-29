<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ruangan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Ruangan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $ruangan = $this->Ruangan_model->get_all();

        $data = array(
            'ruangan_data' => $ruangan
        );

        $this->template->load('template', 'ruangan/list', $data);
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('ruangan/create_action'),
            'id_ruangan' => set_value('id_ruangan'),
            'nama_ruangan' => set_value('nama_ruangan'),
        );
        $this->template->load('template', 'ruangan/form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_ruangan' => $this->input->post('nama_ruangan', TRUE),
            );

            $this->Ruangan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('ruangan'));
        }
    }

    public function update($id)
    {
        $row = $this->Ruangan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('ruangan/update_action'),
                'id_ruangan' => set_value('id_ruangan', $row->id_ruangan),
                'nama_ruangan' => set_value('nama_ruangan', $row->nama_ruangan),
            );
            $this->template->load('template', 'ruangan/form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ruangan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_ruangan', TRUE));
        } else {
            $data = array(
                'nama_ruangan' => $this->input->post('nama_ruangan', TRUE),
            );

            $this->Ruangan_model->update($this->input->post('id_ruangan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('ruangan'));
        }
    }

    public function delete($id)
    {
        $row = $this->Ruangan_model->get_by_id($id);

        if ($row) {
            $this->Ruangan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('ruangan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('ruangan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_ruangan', 'nama ruangan', 'trim|required');
        $this->form_validation->set_rules('id_ruangan', 'id_ruangan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}
