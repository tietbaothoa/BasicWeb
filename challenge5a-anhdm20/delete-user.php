<?php
session_start();
include 'config.php';

// Kiểm tra xem 'username' có được truyền qua URL không
if (isset($_GET['username'])) {
    $username = $_GET['username'];

    // Câu lệnh SQL để xóa người dùng
    $sql = "DELETE FROM users WHERE username = '$username'";

    if ($conn->query($sql) === TRUE) {
        echo "Người dùng đã được xóa thành công.";
    } else {
        echo "Có lỗi khi xóa người dùng: " . $conn->error;
    }
} else {
    echo "Không có tên người dùng.";
}

// Đóng kết nối
$conn->close();
?>
