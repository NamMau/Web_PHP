<?php
// Kiểm tra xem người dùng đã đăng nhập hay chưa

session_start();
if(!isset($_SESSION['user_name'])) {
    // Nếu chưa đăng nhập, chuyển hướng người dùng đến trang đăng nhập
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Bootstrap JS link -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Font Awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS file -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .admin_image {
            width: 100px;
            object-fit: contain;
        }
        .footer {
            position: absolute;
            bottom: 0;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <div class="container-fluid p-0">
        <!-- First nav -->
        <nav class="navbar navbar-expand-lg navbar-light bg-info">
            <div class="container-fluid">
                <img src="../images/b1.jpg" alt="" class="logo">
                <nav class="navbar navbar-expand-lg">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="" class="nav-link">Welcome</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </nav>

        <!-- Second nav -->
        <div class="bg-light">
            <h3 class="text-center p-2">Manage Details</h3>
        </div>

        <!-- Third nav -->
        <div class="row">
            <div class="col-mg-12 bg-secondary p-1 d-flex align-items-center">
                <div class="px-3">
                    <a href="#"><img src="../images/bird.jpg" alt="" class="admin_image"></a>
                    <p class="text-light text-center"><?php echo $_SESSION['user_name']; ?></p>
                </div>
                
                <div class="button text-center">
                    <button class="my-3"><a href="insert_books.php" class="nav-link text-light bg-info my-1">Insert Book</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">View Book</a></button>
                    <button><a href="index.php?insert_category" class="nav-link text-light bg-info my-1">Insert Categories</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">View Categories</a></button>
                    <button><a href="index.php?insert_type" class="nav-link text-light bg-info my-1">Insert Types</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">View Types</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">All orders</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">All payments</a></button>
                    <button><a href="list_users.php" class="nav-link text-light bg-info my-1">List users</a></button>
                    <button><a href="" class="nav-link text-light bg-info my-1">Logout</a></button>
                </div>
            </div>
        </div>

        <!-- Fourth nav -->
        <div class="container my-5">
            <?php 
                if(isset($_GET['insert_category'])){
                    include('insert_categories.php');
                }
                if(isset($_GET['insert_type'])){
                    include('insert_type.php');
                }
            ?>    
        </div>
        <div class="bg-info p-3 text-center footer">
            <p>@ Designed by NamMau</p>
        </div>
    </div>
</body>
</html>
