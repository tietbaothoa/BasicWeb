<?php
session_start();
include 'config.php';

if(!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$sql = "SELECT * FROM messages WHERE receivername = '$username'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $messages = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Messages</h2>
        <?php if (!empty($messages)): ?>
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Sender Name</th>
                        <th>Receiver Name</th>
                        <th>Message</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($messages as $message): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($message['id']); ?></td>
                            <td><?php echo htmlspecialchars($message['sendername']); ?></td>
                            <td><?php echo htmlspecialchars($message['receivername']); ?></td>
                            <td><?php echo htmlspecialchars($message['message']); ?></td>
                            <td><?php echo htmlspecialchars($message['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning" role="alert">
                Không có tin nhắn nào.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>