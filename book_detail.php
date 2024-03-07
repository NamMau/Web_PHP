<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Detail</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <style>
        /* Custom logo size */
        .custom-logo {
            max-width: 100px; /* Adjust logo size */
            height: auto;
        }

        /* Custom book image size */
        .book-image {
            max-width: 500px; /* Adjust book image size */
            height: 500px;
        }

        /* Custom bold text */
        .bold-text {
            font-weight: bold; /* Set text to bold */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-info">
        <div class="container-fluid p-0">
            <img src="./images/b1.jpg" alt="" class="logo custom-logo">
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
                        <a class="nav-link" href="#">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fa-solid fa-cart-plus"></i><sup>1</sup></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Total Price:</a>
                    </li>
                </ul>
                <form class="d-flex" method="GET">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search_data">
                    <input type="submit" value="Search" class="btn btn-outline-light" name="search_data_book">
                </form>
            </div>
        </div>
    </nav>

    <!-- Book Detail Content -->
    <div class="container">
            <h1 class="mt-3 mb-4 text-center">Book Details</h1>
        <?php
        include('includes/connect.php');

        if(isset($_GET['book_id'])) {
            $book_id = $_GET['book_id'];
            
            // Truy vấn để lấy thông tin chi tiết về cuốn sách
            $query = "SELECT * FROM `book` WHERE `book_id` = $book_id";
            $result = mysqli_query($con, $query);

            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $book_title = $row['book_title'];
                $book_description = $row['book_description'];
                $book_image = $row['book_image'];
                $book_price = $row['book_price'];
                $category_id = $row['category_id'];
                $type_id = $row['type_id'];

                // Hiển thị thông tin chi tiết về cuốn sách và nút "Edit" và "Delete"
                echo "<div class='row my-5'>
                        <div class='col-md-4'>
                            <img src='./admin/book_images/$book_image' class='img-fluid book-image' alt='$book_title'>
                        </div>
                        <div class='col-md-8'>
                            <div class='row'>
                                <div class='col-md-12'>
                                    <h3>Book Title: $book_title</h3>
                                </div>
                                <div class='col-md-12'>
                                    <h3>Description: $book_description</h3>
                                </div>
                                <div class='col-md-12'>
                                    <h3>Price: $book_price</h3>
                                </div>
                                <div class='col-md-12'>
                                    <a href='edit_book.php?book_id=$book_id' class='btn btn-primary'>Edit</a>
                                    <a href='delete_book.php?book_id=$book_id' class='btn btn-danger'>Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>Book not found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Book ID is missing in URL.</div>";
        }
        ?>
    </div>

    <!-- Footer -->
    <footer class="bg-info text-white text-center py-3">
        <p>@ Designed by NamMau</p>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
