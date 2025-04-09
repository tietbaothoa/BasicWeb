<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$sendername = $_SESSION['username'];

if (isset($_POST['send'])) {
    $receivername = urldecode($_GET['username']);
    $message = $_POST['message'];
    $sql = "INSERT INTO messages (sendername, receivername, message) 
            VALUES ('$sendername', '$receivername', '$message')";
    $conn->query($sql);
}

if (isset($_POST['edit'])) {
    $message_id = $_POST['message_id'];
    $new_message = $_POST['new_message'];
    $sql = "UPDATE messages SET message = '$new_message' 
            WHERE id = '$message_id' AND sendername = '$sendername'";
    $conn->query($sql);
}

if (isset($_POST['delete'])) {
    $message_id = $_POST['message_id'];
    $sql = "DELETE FROM messages WHERE id = '$message_id' AND sendername = '$sendername'";
    $conn->query($sql);
}

$sql = "SELECT * FROM messages WHERE sendername = '$sendername' ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">

    <h2>Gửi tin nhắn</h2>
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label>Tin nhắn:</label>
            <textarea name="message" class="form-control" required></textarea>
        </div>
        <button type="submit" name="send" class="btn btn-primary">Gửi</button>
    </form>

    <h2>Tin nhắn đã gửi</h2>
    <?php if ($result->num_rows > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Người nhận</th>
                    <th>Tin nhắn</th>
                    <th>Thời gian</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['receivername']) ?></td>
                    <td><?= htmlspecialchars($row['message']) ?></td>
                    <td><?= $row['created_at'] ?></td>
                    <td>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="message_id" value="<?= $row['id'] ?>">
                            <input type="text" name="new_message" class="form-control d-inline w-50" placeholder="Sửa tin nhắn" required>
                            <button type="submit" name="edit" class="btn btn-sm btn-warning">Sửa</button>
                        </form>
                        <form method="POST" class="d-inline">
                            <input type="hidden" name="message_id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-sm btn-danger" onclick="return confirm('Xoá tin nhắn này?')">Xoá</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Bạn chưa gửi tin nhắn nào.</p>
    <?php endif; ?>

</body>
</html>
