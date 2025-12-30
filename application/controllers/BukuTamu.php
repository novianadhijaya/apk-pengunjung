<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BukuTamu extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function index()
    {
        $this->load->model('Ruangan_model');
        $data['ruangan_list'] = $this->Ruangan_model->get_all();
        $this->load->view('auth/buku_tamu', $data);
    }

    public function checkin()
    {
        // Validation
        $visitor_name = $this->input->post('visitor_name');
        $institution = $this->input->post('institution');

        if (empty($visitor_name) || empty($institution)) {
            $this->session->set_flashdata('status_login', 'Error: Nama dan Institusi wajib diisi.');
            redirect('auth'); // Redirect back to login page
            return;
        }

        // Determine membership type & Autofill
        $member_id = $this->input->post('member_id');
        $membership_type = 'Umum';

        if (!empty($member_id)) {
            $this->load->model('Anggota_model');
            $member = $this->Anggota_model->get_by_kode($member_id);

            if ($member) {
                $membership_type = 'Member';
                // Autofill data from member table, overriding input if necessary
                $visitor_name = $member->nama_anggota;
                $institution = $member->institusi;
            } else {
                // Option: You could error here, or just treat as Non-Anggota with that ID
                // For now, let's treat as Non-Anggota but keep the ID they typed
                $membership_type = 'Umum';
            }
        }

        // Logic Custom Room
        $room_custom = $this->input->post('room_name_custom');
        $room_select = $this->input->post('room_name');
        $final_room = !empty($room_custom) ? $room_custom : $room_select;

        // Prepare data
        $data = array(
            'visitor_name' => $visitor_name,
            'institution' => $institution,
            'member_id' => $member_id,
            'membership_type' => $membership_type,
            'room_name' => $final_room,
            'visit_date' => date('Y-m-d'),
            'visit_time' => date('H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
        );

        // Insert into database
        if ($this->db->insert('visits', $data)) {
            $this->session->set_flashdata('status_login', 'Check-in Berhasil! Selamat datang di Perpustakaan.');
        } else {
            $this->session->set_flashdata('status_login', 'Error: Gagal check-in, silakan coba lagi.');
        }

        redirect('buku_tamu');
    }
}
