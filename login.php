<?php
include('includes/connect.php');

// Bắt đầu phiên làm việc
session_start();

// Xóa thông báo lỗi trước đó (nếu có)
unset($_SESSION['error']);

if(isset($_POST['user_name']) && isset($_POST['user_password'])) {
    // Lấy dữ liệu từ biểu mẫu
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    // Sử dụng prepared statement để tránh SQL Injection
    $query = "SELECT user_id, user_name, user_password FROM users WHERE user_name=?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $user_name);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        // Lấy thông tin người dùng từ cơ sở dữ liệu
        $row = mysqli_fetch_assoc($result);
        $stored_password = $row['user_password'];

        // Kiểm tra mật khẩu
        if(password_verify($user_password, $stored_password)) {
            // Lưu thông tin người dùng vào session
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_name'] = $row['user_name'];
            // Đăng nhập thành công, chuyển hướng đến trang chính sau khi đăng nhập
            header("Location: index.php");
            exit();
        }
    }
    
    // Đăng nhập không thành công, hiển thị thông báo lỗi và chuyển hướng lại trang đăng nhập
    $_SESSION['error'] = "Invalid username or password!";
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <?php 
            if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
        ?>
        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="user_name" class="form-label">Username:</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>
</html>
