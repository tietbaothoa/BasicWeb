<?php
session_start();
include 'config.php';

if (isset($_GET['username'])) {
    $username = $_GET['username'];

    $sql = "DELETE FROM users WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Người dùng đã được xóa thành công.";
    } else {
        echo "Có lỗi khi xóa người dùng: " . $conn->error;
    }
} else {
    echo "Không có tên người dùng.";
}

$conn->close();
?>
