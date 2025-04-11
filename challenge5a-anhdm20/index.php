<?php
session_start();
include 'config.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $sql = "SELECT username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($db_username, $hashed_password, $role);
    $stmt->fetch();

    if (password_verify($password, $hashed_password)) {
        $_SESSION['username'] = $db_username;
        $_SESSION['role'] = $role;
        echo "<script>
            alert('Login success');
            window.location.href='list.php';
        </script>";
        exit();
    } else {
        $error = "Tên đăng nhập hoặc mật khẩu không đúng.";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    
    <style>
        .login-container {
            max-width: 400px;
            margin: 80px auto;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background-color: #fff;
        }
    </style>
</head>
<body class="bg-light">

    <div class="login-container">
        <h3 class="text-center mb-4">Đăng nhập hệ thống</h3>
        
        <?php if ($error): ?>
            <div class="alert alert-danger text-center" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Tên đăng nhập</label>
                <input type="text" name="username" id="username" class="form-control" required placeholder="Nhập tên đăng nhập">
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Nhập mật khẩu">
            </div>

            <button type="submit" class="btn btn-primary btn-block">Đăng nhập</button>
        </form>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
