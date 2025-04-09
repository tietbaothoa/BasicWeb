<?php
include '../config.php';
session_start();

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$is_teacher = ($_SESSION['role'] === 'teacher');
$is_student = ($_SESSION['role'] === 'student');

$sql = "SELECT * FROM assignments";
$result = $conn->query($sql);
if (!$result) {
    die("Lỗi truy vấn: " . $conn->error);
}
?>


<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bài tập</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="text-center mb-4">Danh sách bài tập</h3>

    <?php if ($is_teacher): ?>
        <div class="mb-3 text-right">
            <a href="upload-file.php" class="btn btn-success">Tải lên bài tập mới</a>
        </div>
    <?php endif; ?>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
        <tr>
            <th>ID</th>
            <th>Tiêu đề</th>
            <th>Mô tả</th>
            <th>Giáo viên</th>
            <th>Ngày đăng</th>
            <th>Tệp</th>
            <?php if ($is_teacher): ?>
                <th>Bài nộp</th>
            <?php endif; ?>
            <?php if ($is_student): ?>
                <th>Nộp bài</th>
            <?php endif; ?>
        </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['title']) ?></td>
                <td><?= nl2br(htmlspecialchars($row['description'])) ?></td>
                <td><?= htmlspecialchars($row['teacher_username']) ?></td>
                <td><?= $row['upload_date'] ?></td>
                <td>
                    <a href="<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-primary" download>Tải về</a>
                </td>
                <?php if ($is_teacher): ?>
                    <td>
                        <a href="list-submit.php?task_id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Danh sách bài nộp</a>
                    </td>
                <?php endif; ?>
                <?php if ($is_student): ?>
                    <td>
                        <a href="submit.php?task_id=<?= $row['id'] ?>" class="btn btn-sm btn-warning">Nộp bài</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <div class="mt-4">
        <a href="../list.php" class="btn btn-secondary">Quay lại</a>
    </div>
</div>

<!-- Bootstrap 4 JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>


