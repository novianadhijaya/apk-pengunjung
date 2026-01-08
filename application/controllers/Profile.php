<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Profile extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Tbl_profil_apps_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $app = $this->Tbl_profil_apps_model->get_by_id(1);
        $defaults = array(
            'info_aplikasi' => 'Sistem prediksi pengunjung perpustakaan berbasis web.',
            'tujuan_sistem' => 'Membantu perpustakaan memprediksi jumlah pengunjung bulanan sebagai bahan perencanaan layanan.',
            'metode' => 'Regresi linier sederhana (Y = a + bX) menggunakan data kunjungan bulanan.',
            'pengembang' => 'Nama pengembang / institusi (sesuaikan dengan data Anda).',
        );
        $data = array(
            'app' => $app,
            'info_aplikasi' => $this->profile_field_value($app, 'info_aplikasi', $defaults['info_aplikasi']),
            'tujuan_sistem' => $this->profile_field_value($app, 'tujuan_sistem', $defaults['tujuan_sistem']),
            'metode' => $this->profile_field_value($app, 'metode', $defaults['metode']),
            'pengembang' => $this->profile_field_value($app, 'pengembang', $defaults['pengembang']),
        );
        $this->template->load('template', 'profile/about_us', $data);
    }

    public function read($id)
    {
        $row = $this->Tbl_profil_apps_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id' => $row->id,
                'nama_apps' => $row->nama_apps,
                'judul' => $row->judul,
                'logo' => $row->logo,
            );
            $this->template->load('template', 'profile/tbl_profil_apps_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profile'));
        }
    }

    public function create()
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('profile/create_action'),
            'id' => set_value('id'),
            'nama_apps' => set_value('nama_apps'),
            'judul' => set_value('judul'),
            'logo' => set_value('logo'),
            'info_aplikasi' => set_value('info_aplikasi'),
            'tujuan_sistem' => set_value('tujuan_sistem'),
            'metode' => set_value('metode'),
            'pengembang' => set_value('pengembang'),
        );
        $this->template->load('template', 'profile/tbl_profil_apps_form', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = $this->build_profile_payload();
            $data['logo'] = $this->input->post('logo', TRUE);

            $this->Tbl_profil_apps_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('profile'));
        }
    }

    public function update($id)
    {
        $row = $this->Tbl_profil_apps_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('profile/update_action'),
                'id' => set_value('id', $row->id),
                'nama_apps' => set_value('nama_apps', $row->nama_apps),
                'judul' => set_value('judul', $row->judul),
                'logo' => set_value('logo', $row->logo),
                'info_aplikasi' => set_value('info_aplikasi', $this->profile_field_value($row, 'info_aplikasi', '')),
                'tujuan_sistem' => set_value('tujuan_sistem', $this->profile_field_value($row, 'tujuan_sistem', '')),
                'metode' => set_value('metode', $this->profile_field_value($row, 'metode', '')),
                'pengembang' => set_value('pengembang', $this->profile_field_value($row, 'pengembang', '')),
            );
            $this->template->load('template', 'profile/tbl_profil_apps_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profile'));
        }
    }

    function upload_foto()
    {
        $config['upload_path'] = './assets/foto_profil';
        $config['allowed_types'] = 'gif|jpg|png|jpeg'; // Added jpeg
        $config['file_name'] = 'logo_' . time(); // Unique name

        $this->load->library('upload', $config);
        $this->upload->initialize($config); // Ensure config is loaded

        if ($this->upload->do_upload('logo')) {
            return $this->upload->data();
        } else {
            return NULL;
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id', TRUE));
        } else {
            $data = $this->build_profile_payload();

            // Only try to upload if a file is selected
            if (!empty($_FILES['logo']['name'])) {
                $foto = $this->upload_foto();
                if ($foto && !empty($foto['file_name'])) {
                    $data['logo'] = $foto['file_name'];
                } else {
                    // Upload failed (e.g. wrong type or size)
                    $this->session->set_flashdata('message', 'Upload Error: ' . $this->upload->display_errors());
                    redirect(site_url('profile/update/1'));
                    return;
                }
            }

            $this->Tbl_profil_apps_model->update($this->input->post('id', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('profile/update/1'));
        }
    }

    public function delete($id)
    {
        $row = $this->Tbl_profil_apps_model->get_by_id($id);

        if ($row) {
            $this->Tbl_profil_apps_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('profile'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('profile/'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_apps', 'nama apps', 'trim|required');
        $this->form_validation->set_rules('judul', 'judul', 'trim|required');
        $this->form_validation->set_rules('info_aplikasi', 'info aplikasi', 'trim');
        $this->form_validation->set_rules('tujuan_sistem', 'tujuan sistem', 'trim');
        $this->form_validation->set_rules('metode', 'metode', 'trim');
        $this->form_validation->set_rules('pengembang', 'pengembang', 'trim');
        //$this->form_validation->set_rules('logo', 'logo', 'trim|required');

        $this->form_validation->set_rules('id', 'id', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    private function profile_field_value($row, $field, $fallback)
    {
        if (empty($row) || !isset($row->$field)) {
            return $fallback;
        }

        $value = trim((string) $row->$field);
        return $value !== '' ? $value : $fallback;
    }

    private function build_profile_payload()
    {
        $data = array(
            'nama_apps' => $this->input->post('nama_apps', TRUE),
            'judul' => $this->input->post('judul', TRUE),
        );

        $optional_fields = array('info_aplikasi', 'tujuan_sistem', 'metode', 'pengembang');
        foreach ($optional_fields as $field) {
            if ($this->db->field_exists($field, $this->Tbl_profil_apps_model->table)) {
                $data[$field] = $this->input->post($field, TRUE);
            }
        }

        return $data;
    }

}
