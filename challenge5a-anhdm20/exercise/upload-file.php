<?php
session_start();
include '../config.php';

if(!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: login.php");
    exit();
}


if(isset($_POST['task']) && isset($_FILES['file']['name'])){
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
            $teacher_username = $_SESSION['username'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $upload_date = date("Y-m-d H:i:s");
            $sql = "INSERT INTO assignments (title, description, file_path, upload_date, teacher_username) VALUES ('$title', '$description', '$path', '$upload_date', '$teacher_username')";
            if(mysqli_query($conn, $sql)){
                echo "<script>alert('Upload file success'); 
                window.location.href='list-task.php';
                </script>";
            } else {
                echo "<script>alert('Upload file failed'); 
                window.location.href='upload-file.php';
                </script>";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
  <head>
    <title>Upload Task</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container mt-5">
      <h3 class="text-center mb-4">Tải lên bài tập mới</h3>

      <?php if(isset($mess)) echo $mess; ?>

      <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
          <label for="title">Tiêu đề</label>
          <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="form-group">
          <label for="description">Mô tả</label>
          <textarea name="description" id="description" class="form-control" rows="5" required></textarea>
        </div>

        <div class="form-group">
          <label for="file">Chọn tệp bài tập</label>
          <input type="file" name="file" id="file" class="form-control-file" required>
          <small class="form-text text-muted">Chỉ chấp nhận .pdf, .docx, .txt (tối đa 10MB)</small>
        </div>

        <button type="submit" name="task" class="btn btn-primary">Tải lên</button>
        <a href="list-task.php" class="btn btn-secondary ml-2">Quay lại danh sách</a>
      </form>
    </div>

    <!-- Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  </body>
</html>
