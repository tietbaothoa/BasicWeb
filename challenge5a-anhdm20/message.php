<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if(isset($_POST['read'])) {
    $username = $_SESSION['username'];
    $sql = "SELECT * FROM messages WHERE receivername = '$username'"; 
    $result = $conn->query($sql);
    if (!$result) {
        die("Lỗi truy vấn: " . $conn->error);
    }
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Hộp thư đến</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Tin nhắn đã nhận</h3>

    <form method="post" class="text-center mb-4">
        <button type="submit" name="read" class="btn btn-primary">Xem tin nhắn</button>
    </form>

    <?php if (!empty($messages)): ?>
        <table class="table table-bordered table-hover">
            <thead class="thead-dark">
            <tr>
                <th>ID</th>
                <th>Người gửi</th>
                <th>Người nhận</th>
                <th>Nội dung</th>
                <th>Thời gian</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= $msg['id'] ?></td>
                    <td><?= htmlspecialchars($msg['sendername']) ?></td>
                    <td><?= htmlspecialchars($msg['receivername']) ?></td>
                    <td><?= nl2br(htmlspecialchars($msg['message'])) ?></td>
                    <td><?= $msg['created_at'] ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif (isset($_POST['read'])): ?>
        <div class="alert alert-info text-center">Không có tin nhắn nào.</div>
    <?php endif; ?>

    <a href="list.php" class="btn btn-secondary mt-3">Quay lại</a>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

