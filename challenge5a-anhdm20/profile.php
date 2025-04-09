<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$is_teacher = ($_SESSION['role'] === 'teacher');
$is_student = ($_SESSION['role'] === 'student');

$username = urldecode($_GET['username']);

$sql = "SELECT username, fullname, email, phonenumber, avatar FROM users WHERE username = '$username'";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Chi tiết người dùng</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .avatar {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Thông tin chi tiết người dùng</h3>

    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body text-center">
            <?php if (!empty($user['avatar'])): ?>
                <img src="<?= htmlspecialchars($user['avatar']) ?>" alt="Avatar" class="avatar">
            <?php else: ?>
                <img src="default-avatar.png" alt="Avatar" class="avatar">
            <?php endif; ?>

            <h5 class="card-title mt-3"><?= htmlspecialchars($user['fullname']) ?></h5>
            <p class="card-text"><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></p>
            <p class="card-text"><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
            <p class="card-text"><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phonenumber']) ?></p>

            <a href="list.php" class="btn btn-secondary mt-3">Quay lại danh sách</a>
            <a href="chat.php?username=<?= urlencode($user['username']) ?>" class="btn btn-primary mt-3">Chat</a>
        </div>
    </div>
</div>
</body>
</html>
