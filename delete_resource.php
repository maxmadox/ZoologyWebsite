<?php
include 'database/database.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM resources WHERE id=$id");
    if ($result && $row = $result->fetch_assoc()) {
        if ($row['type'] == 'file' && file_exists($row['file_path'])) {
            unlink($row['file_path']);
        }
        $conn->query("DELETE FROM resources WHERE id=$id");
    }
}
header("Location: manage_resources.php");
exit;
?>
