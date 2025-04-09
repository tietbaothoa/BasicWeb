<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$is_teacher = ($_SESSION['role'] === 'teacher');
$is_student = ($_SESSION['role'] === 'student');

$sql = "SELECT username, fullname, email, phonenumber, avatar FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng</title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="container mt-4">
    <h2 class="mb-4 text-center">Danh sách người dùng</h2>

    <div class="d-flex justify-content-end mb-3">
        <a href="logout.php" class="btn btn-danger ml-2">Đăng xuất</a>
    </div>

    <div class="mb-3">
        <?php if ($is_teacher): ?>
            <a href="add.php" class="btn btn-success">Thêm sinh viên</a>
        <?php endif; ?>
        
        <a href="exercise/list-task.php" class="btn btn-success">Bài tập</a>
        <a href="edit-profile.php" class="btn btn-primary ml-2">Chỉnh sửa thông tin cá nhân</a>
        <a href="list-chat.php" class="btn btn-info ml-2">Tin nhắn</a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
            <thead class="thead-light">
                <tr>
                    <th>Avatar</th>
                    <th>Tên đăng nhập</th>
                    <th>Họ và tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td>
                            <img src="uploads/<?php echo htmlspecialchars($row['avatar'] ?? 'default.png'); ?>" 
                                 alt="Avatar" class="avatar">
                        </td>
                        <td>
                            <a href="profile.php?username=<?php echo urlencode($row['username']); ?>">
                                <?php echo htmlspecialchars($row['username']); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($row['fullname']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phonenumber']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
