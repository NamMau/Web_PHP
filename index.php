<?php
session_start();
include('includes/connect.php');

// Kiểm tra xem người dùng đã đăng nhập hay chưa
if(isset($_SESSION['user_name'])) {
    // Nếu đã đăng nhập, hiển thị tên người dùng
    $user_id = $_SESSION['user_id'];
    $user_name = $_SESSION['user_name'];    
} else {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}

// Xử lý logout
if(isset($_POST['logout'])) {
    // Xóa session và đăng xuất
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

// Hàm tìm kiếm sách
function searchBooks($connection, $keyword) {
    // Xây dựng truy vấn tìm kiếm
    $query = "SELECT * FROM `book` WHERE `book_title` LIKE '%$keyword%'";
    $result = mysqli_query($connection, $query);

    // Kiểm tra xem có sách nào được tìm thấy hay không
    if(mysqli_num_rows($result) > 0) {
        // Tạo một mảng để lưu trữ kết quả tìm kiếm
        $books = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $books[] = $row;
        }
        return $books;
    } else {
        // Trả về một mảng rỗng nếu không tìm thấy sách
        return [];
    }
}

// Tạo một biến để lưu trữ sản phẩm
$products = [];

// Kiểm tra xem người dùng đã gửi yêu cầu tìm kiếm chưa
if(isset($_GET['search_data_book'])) {
    // Lấy từ khóa tìm kiếm từ form
    $keyword = $_GET['search_data'];

    // Gọi hàm searchBooks để tìm kiếm sách và lưu kết quả vào biến $products
    $products = searchBooks($con, $keyword);
    if(empty($products)) {
        echo "<div class='alert alert-warning' role='alert'>No books found matching your search.</div>";
    }
} else {
    // Nếu không có yêu cầu tìm kiếm, hiển thị toàn bộ sách
    $select_query = "SELECT * FROM `book`";
    $result_query = mysqli_query($con, $select_query);

    // Lưu tất cả sản phẩm vào biến $products
    while ($row = mysqli_fetch_assoc($result_query)) {
        $products[] = $row;
    }
}

// Kiểm tra xem có sản phẩm được thêm vào giỏ hàng không
if(isset($_POST['add_to_cart'])) {
    // Lấy book_id của sản phẩm được thêm vào giỏ hàng
    $book_id = $_POST['book_id'];

    // Khởi tạo hoặc cập nhật session giỏ hàng
    if(isset($_SESSION['cart'])) {
        $_SESSION['cart'][] = $book_id;
    } else {
        $_SESSION['cart'] = array($book_id);
    }

    // Cập nhật tổng giá trị giỏ hàng
    $total_price = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;
    $book_price_query = "SELECT book_price FROM book WHERE book_id = $book_id";
    $book_price_result = mysqli_query($con, $book_price_query);
    $book_price_row = mysqli_fetch_assoc($book_price_result);
    $total_price += $book_price_row['book_price'];
    $_SESSION['total_price'] = $total_price;

    // Hiển thị thông báo cho người dùng biết sản phẩm đã được thêm vào giỏ hàng
    echo "<div class='alert alert-success' role='alert'>Product added to cart successfully!</div>";
}

// Đếm số lượng sản phẩm trong giỏ hàng
$cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Website</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!--navbar -->
    <div class="container-fluid">
        <!--first nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid p-0">
                <img src="./images/b1.jpg" alt="" class="logo">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Books</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a> 
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="cart.php"><i class="fa-solid fa-cart-plus"></i><sup><?php echo $cart_count; ?></sup></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Total Price: <?php echo isset($_SESSION['total_price']) ? $_SESSION['total_price'] : '0.00'; ?></a>
                        </li>
                    </ul>
                    <form class="d-flex" method="GET" action="index.php">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                        <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_book">
                    </form>
                </div>
            </div>
        </nav>

        <!--second nav -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-secondary">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="">Welcome to my Shopping Web</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><?php echo $user_name; ?></a> <!-- Hiển thị tên người dùng -->
                </li>
                <li class="nav-item">
                    <form method="post" action="">
                        <button type="submit" class="btn btn-danger" name="logout">Logout</button> <!-- Nút logout -->
                    </form>
                </li>
            </ul> 
        </nav>

        <!-- third nav -->
        <div class="bg-light">
            <h3 class="text-center">Books Store</h3>
            <p class="text-center">You can buy any of books</p>
        </div>

        <!-- fourth nav -->
        <div class="row px-3">
            <div class="col-md-10">
                <!-- books-->
                <div class="row">
                    <!--fetching book -->
                    <?php
                    // Hiển thị sản phẩm từ biến $products
                    foreach ($products as $product) {
                        $book_id = $product['book_id'];
                        $book_title = $product['book_title'];
                        $book_description = $product['book_description'];
                        $book_image = $product['book_image'];
                        $book_price = $product['book_price'];
                        $category_id = $product['category_id'];
                        $type_id = $product['type_id'];

                        echo "<div class='col-md-4 mb-2'>
                                    <div class='card'>
                                        <img src='./admin/book_images/$book_image' class='card-img-top' alt='$book_title'>
                                        <div class='card-body'>
                                            <h5 class='card-title'>$book_title</h5>
                                            <p class='card-text'>$book_description</p>
                                            <form method='post' action='index.php'>
                                                <input type='hidden' name='book_id' value='$book_id'>
                                                <button type='submit' name='add_to_cart' class='btn btn-info'>Add to cart</button>
                                            </form>
                                            <a href='book_detail.php?book_id=$book_id' class='btn btn-secondary'>View more</a>
                                        </div>
                                    </div>
                                </div>";
                    }
                    ?>
                </div>
                <!-- row end -->
            </div>

            <!-- col-md-10 end -->
            <div class="col-md-2 bg-secondary p-0">
                <!--books to be displayed-->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="#" class="nav-link text-light"><h4>Type</h4></a>
                    </li>
                    <?php 
                        $select_type = "Select * from `type`";
                        $result_type = mysqli_query($con,$select_type);
                        while($row_data = mysqli_fetch_assoc($result_type)){
                            $type_title = $row_data['type_title'];
                            $type_id = $row_data['type_id'];
                            echo "<li class='nav-item'>
                                    <a href='index.php?type= $type_id' class='nav-link text-light'>$type_title</a>
                                </li>";
                        }
                    ?>
                </ul>
            
                <!--categories to displayed-->
                <ul class="navbar-nav me-auto text-center">
                    <li class="nav-item bg-info">
                        <a href="#" class="nav-link text-light"><h4>Categories</h4></a>
                    </li>
                    <?php 
                        $select_categories = "Select * from `categories`";
                        $result_categories = mysqli_query($con,$select_categories);
                        while($row_data = mysqli_fetch_assoc($result_categories)){
                            $category_title = $row_data['category_title'];
                            $category_id = $row_data['category_id'];
                            echo "<li class='nav-item'>
                                    <a href='index.php?category= $category_id' class='nav-link text-light'>$category_title</a>
                                </li>";
                        }
                    ?>
                </ul>
            </div>
            <!-- col-md-2 end -->
        </div>
        <!-- row end -->

        <!-- last child -->
        <div class="bg-info p-3 text-center">
            <p>@ Designed by NamMau</p>
        </div>
    </div>
    <!-- container-fluid end -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
