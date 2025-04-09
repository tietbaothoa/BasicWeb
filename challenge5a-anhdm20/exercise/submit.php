<?php
session_start();
include '../config.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'student') {
    header("Location: login.php");
    exit();
}

$student_username = $_SESSION['username'];

if(isset($_POST['submit']) && isset($_FILES['file']['name'])){
    $filename = time()."_".basename($_FILES['file']['name']);
    $path = "uploads/".$filename;
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_size = $_FILES['file']['size'];
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $allowed_ext = array("pdf", "docx", "txt");
    if($file_size > 10485760){
        $mess = "<h4 style='color: red;'>File is too big</h4>";
    }
    elseif(!in_array($ext, $allowed_ext))
        $mess = "<h4 style='color: red;'>File type not allowed</h4>";
    else{
        if(move_uploaded_file($file_tmp, $path)){
            $task_id = $_GET['task_id'];
            $submit_date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO submissions (task_id, student_username, file_path, filename, upload_date) VALUES ('$task_id', '$student_username', '$path', '$filename', '$submit_date')";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Submit file success'); 
                window.location.href='list-task.php';
                </script>";
            } else {
                echo "<script>alert('Submit file failed'); 
                window.location.href='list-task.php';
                </script>";
            }
        }
    }

}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>Nộp bài</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-5">
    <h3 class="text-center mb-4">Nộp bài tập</h3>

    <?php if (isset($mess)) echo $mess; ?>

    <form method="post" enctype="multipart/form-data">
      <div class="form-group">
        <label for="file">Chọn tệp bài làm</label>
        <input type="file" name="file" id="file" class="form-control-file" required>
        <small class="form-text text-muted">Chấp nhận .pdf, .docx, .txt (tối đa 10MB)</small>
      </div>

      <button type="submit" name="submit" class="btn btn-success">Nộp bài</button>
      <a href="list-task.php" class="btn btn-secondary ml-2">Quay lại danh sách</a>
    </form>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

