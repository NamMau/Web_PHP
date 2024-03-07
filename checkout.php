<?php
session_start();
include('includes/connect.php');

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (!isset($_SESSION['user_name'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Lấy thông tin người dùng từ session
$user_id = $_SESSION['user_id'];

// Lấy thông tin đơn hàng từ session
if (isset($_SESSION['cart']) && isset($_SESSION['total_price'])) {
    // Lấy danh sách sách trong giỏ hàng và tổng giá trị
    $cart_items = $_SESSION['cart'];
    $total_price = $_SESSION['total_price'];

    // Lặp qua từng sách trong giỏ hàng để lưu vào bảng orders
    foreach ($cart_items as $book_id) {
        // Số lượng sách mặc định là 1, bạn có thể điều chỉnh theo yêu cầu
        $quantity = 1;

        // Tạo truy vấn để chèn dữ liệu vào bảng orders
        $insert_order_query = "INSERT INTO orders (user_id, book_id, quantity, total_price) VALUES ('$user_id', '$book_id', '$quantity', '$total_price')";

        // Thực thi truy vấn
        $insert_result = mysqli_query($con, $insert_order_query);

        // Kiểm tra xem truy vấn có thành công hay không
        if (!$insert_result) {
            // Nếu không thành công, hiển thị thông báo lỗi và dừng chương trình
            echo "Error: " . mysqli_error($con);
            exit();
        }
    }

    // Sau khi lưu đơn hàng thành công, xóa thông tin giỏ hàng và tổng giá trị từ session
    unset($_SESSION['cart']);
    unset($_SESSION['total_price']);

    // Hiển thị thông báo thành công và chuyển hướng người dùng đến trang khác hoặc cùng trang nếu cần
    echo "<script>alert('Order placed successfully!');</script>";
    // Chuyển hướng người dùng đến trang khác sau khi đã đặt hàng thành công
    header("Location: index.php");
    exit();
} else {
    // Nếu không có giỏ hàng hoặc tổng giá trị, hiển thị thông báo lỗi và chuyển hướng người dùng đến trang khác hoặc cùng trang nếu cần
    echo "<script>alert('No items in the cart!');</script>";
    // Chuyển hướng người dùng đến trang khác nếu không có giỏ hàng hoặc tổng giá trị
    header("Location: index.php");
    exit();
}
?>
