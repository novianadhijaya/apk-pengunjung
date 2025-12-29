<?php
// Connect to database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengunjung";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dummy Arrays
$names = ['Budi Santoso', 'Siti Aminah', 'Rudi Hartono', 'Dewi Lestari', 'Agus Setiawan', 'Rina Marlina', 'Joko Susilo', 'Maya Putri', 'Eko Prasetyo', 'Nurul Hidayah'];
$institutions = ['Universitas Indonesia', 'ITB', 'UGM', 'SMA Negeri 1', 'Umum', 'Dinas Pendidikan', 'Perpustakaan Daerah'];
$rooms = ['Ruang Baca Umum', 'Ruang Koleksi Referensi', 'Layanan Sirkulasi', 'Ruang Multimedia', 'Layanan Anak'];

// Generate 500 records for 2024
for ($i = 0; $i < 500; $i++) {
    $month = rand(1, 12);
    $day = rand(1, 28);
    $hour = rand(8, 16);
    $minute = rand(0, 59);

    // Create date string
    // Create date string
    $year = date("Y"); // Dynamic current year
    $date = sprintf("%s-%02d-%02d", $year, $month, $day);
    $time = sprintf("%02d:%02d:00", $hour, $minute);

    // Random data
    $name = $names[array_rand($names)];
    $inst = $institutions[array_rand($institutions)];
    $room = $rooms[array_rand($rooms)];
    $type = (rand(0, 10) > 3) ? 'Non-Anggota' : 'Anggota'; // 30% chance of being Anggota
    $member_id = ($type == 'Anggota') ? rand(10000, 99999) : NULL;

    // Simulate trend: More visitors in Month 5 (May) and 10 (Oct) for "Exams"
    if (($month == 5 || $month == 10) && rand(0, 1)) {
        // Add extra probability to insert
    }

    $sql = "INSERT INTO visits (visitor_name, institution, room_name, membership_type, member_id, visit_date, visit_time, created_at)
            VALUES ('$name', '$inst', '$room', '$type', '$member_id', '$date', '$time', '$date $time')";

    $conn->query($sql);
}

echo "Dummy data inserted successfully";
$conn->close();
?>