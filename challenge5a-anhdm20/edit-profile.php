<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

if(isset($_POST['update'])){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $phonenumber = $_POST['phonenumber'];

    if (empty($password) || empty($email) || empty($phonenumber)){
        echo "<script>
                alert('Update failed');
                window.location.href = 'list.php';
            </script>";
    } else {
        $avatar = $_FILES['avatar']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($avatar);

        if (move_uploaded_file($_FILES['avatar']['tmp_name'], $target_file)) {
            $query = "UPDATE users SET password = '$password', email = '$email', phonenumber = '$phonenumber', avatar = '$target_file' WHERE username = '$username'";
        } else {
            echo "<script>
            alert('Failed to upload avatar');
            window.location.href = 'edit-profile.php';
            </script>";
            exit();
        }

        if(mysqli_query($conn, $query)){
            echo "<script>
                alert('Update Success!');
                window.location.href = 'list.php';
            </script>"; 
        } else {
            echo "<script>
                alert('Update failed');
                window.location.href = 'list.php';
            </script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Cập nhật thông tin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 600px;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Cập nhật thông tin</h2>

        <div class="text-right mb-3">
            <a href="logout.php" class="btn btn-danger">Đăng xuất</a>
        </div>

        <form method="POST" action="edit-profile.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Tên đăng nhập:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?= $_SESSION['username']; ?>" readonly>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" required>
            </div>

            <div class="form-group">
                <label for="phonenumber">Số điện thoại:</label>
                <input type="text" class="form-control" name="phonenumber" id="phonenumber" required>
            </div>

            <div class="form-group">
                <label for="avatar">Ảnh đại diện:</label>
                <input type="file" class="form-control-file" name="avatar" id="avatar" accept="image/*">
            </div>

            <button type="submit" name="update" class="btn btn-primary btn-block">Cập nhật</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
