<?php
include('includes/connect.php');

if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];
    
    // Truy vấn để xóa sách khỏi cơ sở dữ liệu
    $query = "DELETE FROM `book` WHERE `book_id` = $book_id";
    $result = mysqli_query($con, $query);

    if($result) {
        // Nếu xóa thành công, chuyển hướng người dùng về trang danh sách sách hoặc trang chính
        header("Location: index.php"); // Thay thế "books.php" bằng đường dẫn đến trang bạn muốn chuyển hướng
        exit();
    } else {
        // Nếu xóa không thành công, hiển thị thông báo lỗi
        echo "Error deleting book: " . mysqli_error($con);
    }
} else {
    // Nếu không có book_id được truyền, hiển thị thông báo lỗi
    echo "Book ID is missing.";
}
?>
