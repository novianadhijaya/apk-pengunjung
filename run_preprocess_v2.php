<?php
// Script to run preprocessing manually (Recreated)

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengunjung";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) { die("Connection failed: " . $conn->connect_error); }

echo "Starting preprocessing...\n";

// 1. Get cleaned monthly counts
$sql_cleaned = "SELECT YEAR(visit_date) AS y, MONTH(visit_date) AS m, COUNT(*) AS total
                FROM (
                    SELECT DISTINCT member_id, visitor_name, membership_type, institution, room_name, visit_date, visit_time
                    FROM visits
                    WHERE visit_date IS NOT NULL AND visit_date <> '' AND visit_date <> '0000-00-00'
                      AND visitor_name IS NOT NULL AND visitor_name <> ''
                ) v
                GROUP BY YEAR(visit_date), MONTH(visit_date)
                ORDER BY YEAR(visit_date), MONTH(visit_date)";

$result = $conn->query($sql_cleaned);
$rows = [];
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) { $rows[] = $row; }
}

if (count($rows) === 0) { die("No data to process.\n"); }

// 2. Prepare data
$formatted_rows = [];
$x = 1;
foreach ($rows as $r) {
    $formatted_rows[] = [ 'year' => (int)$r['y'], 'month' => (int)$r['m'], 'x_period' => $x, 'y_total' => (int)$r['total'] ];
    $x++;
}

// 3. Truncate & Insert
$conn->query("TRUNCATE TABLE monthly_visits");
$stmt = $conn->prepare("INSERT INTO monthly_visits (year, month, x_period, y_total) VALUES (?, ?, ?, ?)");
foreach ($formatted_rows as $row) {
    $stmt->bind_param("iiii", $row['year'], $row['month'], $row['x_period'], $row['y_total']);
    $stmt->execute();
}

$stmt->close();
$conn->close();

echo "Preprocessing complete. Processed " . count($formatted_rows) . " periods.\n";
?>
