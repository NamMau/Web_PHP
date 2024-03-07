<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa
session_start();
if (!isset($_SESSION['user_name'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Bao gồm tệp kết nối đến cơ sở dữ liệu
include('../includes/connect.php');

// Truy vấn để lấy danh sách người dùng
$query = "SELECT user_id, user_name FROM users";
$result = mysqli_query($con, $query);

// Kiểm tra kết nối và truy vấn
if (!$result) {
    die("Query failed: " . mysqli_error($con));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List Users</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1 class="mt-5 mb-3">List Users</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Duyệt qua kết quả trả về từ truy vấn và hiển thị thông tin người dùng trong bảng
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['user_id'] . "</td>";
                    echo "<td>" . $row['user_name'] . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
        <a href="admin_dashboard.php" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
