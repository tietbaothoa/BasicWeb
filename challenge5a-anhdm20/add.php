<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $fullname = $_POST["fullname"];
    $email = $_POST["email"];
    $phonenumber = $_POST["phonenumber"];
    $role = "student";

    // Kiểm tra username đã tồn tại chưa
    $checkUser = $conn->query("SELECT username FROM users WHERE username = '$username'");

    if ($checkUser->num_rows > 0) {
        echo "<div class='alert alert-danger'>Tên đăng nhập đã tồn tại!</div>";
    } else {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $sql = "INSERT INTO users (username, password, fullname, email, phonenumber, role) 
                VALUES ('$username', '$hashed_password', '$fullname', '$email', '$phonenumber', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Thêm sinh viên thành công!');
                    window.location.href = 'list.php';
                  </script>";
            exit();
        } else {
            echo "<div class='alert alert-danger'>Lỗi khi thêm tài khoản: " . $conn->error . "</div>";
        }
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sinh Viên</title>
    <!-- Bootstrap 4 CDN -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="text-right mb-3">
        <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
    </div>

    <h2 class="text-center mb-4">Thêm Sinh Viên</h2>

    <!-- Display messages -->
    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <form method="post" action="add.php" class="bg-light p-4 rounded shadow">
        <div class="form-group">
            <label for="username">Tên đăng nhập</label>
            <input type="text" id="username" name="username" class="form-control" placeholder="Tên đăng nhập" required>
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu</label>
            <input type="password" id="password" name="password" class="form-control" placeholder="Mật khẩu" required>
        </div>
        <div class="form-group">
            <label for="fullname">Họ và tên</label>
            <input type="text" id="fullname" name="fullname" class="form-control" placeholder="Họ và tên" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="phonenumber">Số điện thoại</label>
            <input type="text" id="phonenumber" name="phonenumber" class="form-control" placeholder="Số điện thoại" required>
        </div>

        <button type="submit" class="btn btn-success btn-block">Thêm Sinh Viên</button>
    </form>

    <div class="mt-3 text-center">
        <a href="list.php" class="btn btn-secondary">Quay lại danh sách</a>
    </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>
</html>
