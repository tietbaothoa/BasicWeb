<?php
session_start();
include '../config.php';

$submissions = []; 

if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}
if (isset($_GET['task_id'])) {
    $task_id = intval($_GET['task_id']); 
    $sql = "SELECT * FROM submissions WHERE task_id = '$task_id'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        while ($row = mysqli_fetch_assoc($result)) {
            $submissions[] = $row;
        }
    } else {
        die("Lỗi truy vấn: " . $conn->error);
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách bài làm</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4 text-center">Danh sách bài làm của sinh viên</h3>

    <?php if (count($submissions) === 0): ?>
        <div class="alert alert-info">Chưa có sinh viên nào nộp bài cho bài tập này.</div>
    <?php else: ?>
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>STT</th>
                    <th>Tên sinh viên</th>
                    <th>Tên file</th>
                    <th>Ngày nộp</th>
                    <th>Tải file</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($submissions as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1 ?></td>
                        <td><?= htmlspecialchars($row['student_username']) ?></td>
                        <td><?= htmlspecialchars($row['filename']) ?></td>
                        <td><?= $row['upload_date'] ?></td>
                        <td>
                            <a href="<?= $row['file_path'] ?>" target="_blank" class="btn btn-sm btn-primary" download>Tải về</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="list-task.php" class="btn btn-secondary">Quay lại danh sách bài tập</a>
</div>
</body>
</html>