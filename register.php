<!-- register.php -->
<?php 
include('includes/connect.php'); 

if(isset($_POST['user_name']) && isset($_POST['user_password'])) {
    // Lấy dữ liệu từ biểu mẫu
    $user_name = $_POST['user_name'];
    $user_password = $_POST['user_password'];

    // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Tạo truy vấn SQL để chèn dữ liệu vào cơ sở dữ liệu
    $query = "INSERT INTO users (user_name, user_password) VALUES ('$user_name', '$hashed_password')";

    // Thực thi truy vấn và kiểm tra kết quả
    if(mysqli_query($con, $query)) {
        // Chuyển hướng người dùng đến trang đăng nhập sau khi đăng ký thành công
        header("Location: login.php");
        exit(); // Đảm bảo không có mã HTML hoặc các lệnh khác thực hiện sau lệnh chuyển hướng
    } 
    else {
        echo "Error: " . mysqli_error($con);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        <form action="register.php" method="POST"> <!-- Điều chỉnh action thành register.php -->
            <div class="mb-3">
                <label for="user_name" class="form-label">Username:</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="user_password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="user_password" name="user_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</body>
</html>
