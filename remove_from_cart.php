<?php
session_start();

// Kiểm tra xem book_id đã được truyền từ URL hay không
if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Kiểm tra xem giỏ hàng đã được khởi tạo hay chưa
    if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Tìm vị trí của book_id trong session giỏ hàng
        $key = array_search($book_id, $_SESSION['cart']);
        
        // Xóa book_id khỏi session giỏ hàng nếu nó tồn tại
        if($key !== false) {
            unset($_SESSION['cart'][$key]);
        }
    }
}

// Chuyển hướng trở lại trang giỏ hàng
header("Location: cart.php");
?>
