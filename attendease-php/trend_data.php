<?php
header('Content-Type: application/json');

$pdo = new PDO("mysql:host=localhost;dbname=attendease", "root", "");

$sql = "SELECT l.fname, 
               SUM(CASE WHEN a.status = 'Tardy' THEN 1 ELSE 0 END) AS tardy_count,
               SUM(CASE WHEN a.status = 'Absent' THEN 1 ELSE 0 END) AS absent_count
        FROM attendance a
        INNER JOIN learner l ON a.learnerID = l.learnerID
        GROUP BY l.fname
        ORDER BY l.fname ASC";

$stmt = $pdo->query($sql);

$labels = [];
$tardy = [];
$absent = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $labels[] = $row['fname'];
    $tardy[] = (int)$row['tardy_count'];
    $absent[] = (int)$row['absent_count'];
}

echo json_encode([
    "labels" => $labels,
    "tardy" => $tardy,
    "absent" => $absent
]);
?>
