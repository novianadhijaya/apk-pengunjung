<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seeder extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // is_login(); // Temporarily disabled for CLI/Curl access
        $this->load->database();
        $this->load->model('Anggota_model');
    }

    public function index()
    {
        echo "<pre>";
        echo "Cleaning up old dummy data (Aug-Dec 2025)...\n";

        // 1. DELETE old dummy data
        $this->db->where('visit_date >=', '2025-08-01');
        $this->db->where('visit_date <=', '2025-12-31');
        $this->db->where('visit_time !=', null); // Safety check
        $this->db->delete('visits');

        echo "Deleted old rows. Starting generation with LOW VOLUME FLUCTUATING patterns...\n";

        // Fetch real members
        $members = $this->Anggota_model->get_all();
        $member_count = count($members);

        // Fake data sources
        $first_names = ['Budi', 'Siti', 'Rina', 'Joko', 'Dewi', 'Ahmad', 'Putri', 'Rudi', 'Eka', 'Fajar', 'Nina', 'Hadi', 'Lina', 'Dian', 'Bayu', 'Mega', 'Toni', 'Rani', 'Dedi', 'Yulia'];
        $last_names = ['Santoso', 'Wati', 'Widodo', 'Sartika', 'Dani', 'Saputra', 'Indah', 'Kurniawan', 'Pratama', 'Wijaya', 'Susanti', 'Maulana', 'Hidayat', 'Kusuma', 'Lestari', 'Utami', 'Nugroho', 'Wibowo', 'Yuliana', 'Astuti'];
        $institutions = ['Umum', 'Universitas Terbuka', 'SMA 1', 'SMA 2', 'Unand', 'UNP', 'Dinas Pendidikan', 'Masyarakat Umum', 'Mahasiswa'];
        $rooms = ['Ruang Baca', 'Ruang Sirkulasi', 'Layanan Internet', 'Multimedia', 'Ruang Referensi'];

        // Define specific ranges per month for LOW VOLUME (Max ~100/month)
        // Avg ~25 days/month
        // Format: [min_daily, max_daily]
        $month_patterns = [
            '08' => [2, 4], // Aug: Moderate (~75 total)
            '09' => [3, 6], // Sep: High (~110 total)
            '10' => [1, 3], // Oct: Low (~50 total)
            '11' => [2, 5], // Nov: Med-High (~85 total)
            '12' => [1, 2], // Dec: Very Low (~35 total)
        ];

        $start_date = strtotime('2025-08-01');
        $end_date = strtotime('2025-12-31');

        $current_date = $start_date;
        $total_inserted = 0;

        while ($current_date <= $end_date) {
            // Skip Sundays
            if (date('N', $current_date) == 7) {
                $current_date = strtotime('+1 day', $current_date);
                continue;
            }

            $current_month = date('m', $current_date);
            $range = $month_patterns[$current_month];

            // Random daily visits within the month's specific range
            $daily_visits = rand($range[0], $range[1]);

            for ($i = 0; $i < $daily_visits; $i++) {
                // 40% chance of being a member
                $is_member = (rand(1, 100) <= 40) && ($member_count > 0);

                if ($is_member) {
                    $member = $members[array_rand($members)];
                    $visitor_name = $member->nama_anggota;
                    $institution = $member->institusi;
                    $membership_type = 'Anggota';
                    $member_id = $member->kode_anggota;
                } else {
                    $visitor_name = $first_names[array_rand($first_names)] . ' ' . $last_names[array_rand($last_names)];
                    $institution = $institutions[array_rand($institutions)];
                    $membership_type = 'Umum';
                    $member_id = '';
                }

                $visit_date = date('Y-m-d', $current_date);

                // Random time
                $hour = rand(8, 16);
                $minute = rand(0, 59);
                $visit_time = sprintf('%02d:%02d:%02d', $hour, $minute, rand(0, 59));

                $data = [
                    'visitor_name' => $visitor_name,
                    'institution' => $institution,
                    'membership_type' => $membership_type,
                    'member_id' => $member_id,
                    'room_name' => $rooms[array_rand($rooms)],
                    'visit_date' => $visit_date,
                    'visit_time' => $visit_time,
                    'created_at' => $visit_date . ' ' . $visit_time
                ];

                $this->db->insert('visits', $data);
                $total_inserted++;
            }
            $current_date = strtotime('+1 day', $current_date);
        }

        echo "Regeneration Complete. Inserted $total_inserted new visits (Low Volume).\n";
        echo "</pre>";
    }
}
