<?php
session_start();
include('includes/connect.php');

// Kiểm tra xem session giỏ hàng đã được tạo chưa
if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<div class='alert alert-info' role='alert'>Giỏ hàng của bạn đang trống.</div>";
} else {
    // Lấy danh sách ID sách từ session giỏ hàng
    $book_ids = $_SESSION['cart'];

    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

    // Tạo truy vấn SQL để lấy thông tin chi tiết của các sách trong giỏ hàng
    $query = "SELECT * FROM book WHERE book_id IN (" . implode(',', $book_ids) . ")";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0) {
        echo "<!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Cart</title>
                <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH' crossorigin='anonymous'>
                <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css' integrity='sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==' crossorigin='anonymous' referrerpolicy='no-referrer' />
                <link rel='stylesheet' href='style.css'>
            </head>
            <body>
                <!--navbar -->
                <?php include('navbar.php'); ?>
                <div class='container'>
                    <h1>Your Cart</h1>";
        echo "<table class='table'>";
        echo "<thead>
                <tr>
                    <th>Book Name</th>
                    <th>Book Image</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Action</th>
                </tr>
              </thead>";
        echo "<tbody>";

        // Biến để tính tổng giá trị của giỏ hàng
        $total_price = 0;

        while ($row = mysqli_fetch_assoc($result)) {
            $book_id = $row['book_id'];
            $book_title = $row['book_title'];
            $book_image = $row['book_image'];
            $book_price = $row['book_price'];

            // Đếm số lượng của sách trong giỏ hàng
            $book_quantity = array_count_values($book_ids)[$book_id];

            // Tính tổng giá tiền cho từng loại sách
            $book_total_price = $book_price * $book_quantity;

            // Tính tổng giá tiền của toàn bộ giỏ hàng
            $total_price += $book_total_price;

            echo "<tr>
                    <td>$book_title</td>
                    <td><img src='./admin/book_images/$book_image' alt='$book_title' style='width: 100px;'></td>
                    <td>$book_price</td>
                    <td>$book_quantity</td>
                    <td>$book_total_price</td>
                    <td>
                        <a href='remove_from_cart.php?book_id=$book_id' class='btn btn-danger'>Remove</a>
                    </td>
                  </tr>";
        }

        echo "</tbody>";
        echo "</table>";

        // Hiển thị tổng giá trị của giỏ hàng
        echo "<div class='text-end'><h4>Total Price: $total_price</h4></div>";

        // Nút Checkout
        echo "<div class='text-end'><a href='checkout.php' class='btn btn-primary'>Checkout</a></div>";

        echo "</div>"; // Đóng container
        echo "<?php include('footer.php'); ?>"; // Thêm footer
        echo "</body></html>"; // Đóng thẻ HTML
    } else {
        echo "<div class='alert alert-info' role='alert'>Không có sách nào trong giỏ hàng.</div>";
    }
}
?>
