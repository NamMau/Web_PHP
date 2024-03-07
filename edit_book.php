<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">NamMau Bookstore</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="add_book.php">Add Book</a>
                    </li> -->
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">

        <h1 class="mt-3 mb-4 text-center">Edit Book</h1>

        <?php
        // Include file kết nối đến cơ sở dữ liệu
        include('includes/connect.php');

        // Khai báo biến để lưu thông báo lỗi (nếu có)
        $error_message = '';
        $success_message = '';

        // Kiểm tra xem dữ liệu đã được gửi từ form chưa
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Lấy dữ liệu từ form và gán vào các biến
            $book_id = $_POST['book_id'];
            $book_title = $_POST['book_title'];
            $book_description = $_POST['book_description'];
            $book_price = $_POST['book_price'];

            // Kiểm tra xem người dùng đã tải lên hình ảnh mới chưa
            if (isset($_FILES['book_image']) && $_FILES['book_image']['error'] == 0) {
                // Lưu thông tin về hình ảnh mới
                $target_dir = "admin/book_images/";
                $target_file = $target_dir . basename($_FILES["book_image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                $new_image_name = $book_id . '.' . $imageFileType;
                $target_path = $target_dir . $new_image_name;

                // Kiểm tra kiểu file hợp lệ
                $allowed_types = array('jpg', 'jpeg', 'png', 'gif');
                if (in_array($imageFileType, $allowed_types)) {
                    // Di chuyển và lưu file ảnh mới
                    if (move_uploaded_file($_FILES["book_image"]["tmp_name"], $target_path)) {
                        // Cập nhật đường dẫn ảnh trong cơ sở dữ liệu
                        $query = "UPDATE `book` SET `book_title`='$book_title', `book_description`='$book_description', `book_image`='$new_image_name', `book_price`='$book_price' WHERE `book_id`='$book_id'";
                        $result = mysqli_query($con, $query);

                        if ($result) {
                            $success_message = "Book information updated successfully.";
                        } else {
                            $error_message = "Error updating book information: " . mysqli_error($con);
                        }
                    } else {
                        $error_message = "Sorry, there was an error uploading your file.";
                    }
                } else {
                    $error_message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                // Nếu không có hình ảnh mới được tải lên, chỉ cập nhật các thông tin khác
                $query = "UPDATE `book` SET `book_title`='$book_title', `book_description`='$book_description', `book_price`='$book_price' WHERE `book_id`='$book_id'";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $success_message = "Book information updated successfully.";
                } else {
                    $error_message = "Error updating book information: " . mysqli_error($con);
                }
            }
        }

        // Sau khi xử lý form, hiển thị thông tin sách và form chỉnh sửa
        if (isset($_GET['book_id'])) {
            $book_id = $_GET['book_id'];

            // Truy vấn để lấy thông tin chi tiết về cuốn sách
            $query = "SELECT * FROM `book` WHERE `book_id` = $book_id";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $book_title = $row['book_title'];
                $book_description = $row['book_description'];
                $book_price = $row['book_price'];
                $book_image = $row['book_image'];

                // Hiển thị form để chỉnh sửa thông tin sách
                echo "<form method='POST' action='' enctype='multipart/form-data'>
                        <input type='hidden' name='book_id' value='$book_id'>
                        <div class='mb-3'>
                            <label for='bookTitle' class='form-label'>Book Title</label>
                            <input type='text' class='form-control' id='bookTitle' name='book_title' value='$book_title'>
                        </div>
                        <div class='mb-3'>
                            <label for='bookDescription' class='form-label'>Description</label>
                            <textarea class='form-control' id='bookDescription' rows='3' name='book_description'>$book_description</textarea>
                        </div>
                        <div class='mb-3'>
                            <label for='bookImage' class='form-label'>Book Image</label>
                            <input type='file' class='form-control' id='bookImage' name='book_image'>
                        </div>
                        <div class='mb-3'>
                            <label for='bookPrice' class='form-label'>Price</label>
                            <input type='text' class='form-control' id='bookPrice' name='book_price' value='$book_price'>
                        </div>
                        <button type='submit' class='btn btn-primary'>Save Changes</button>
                    </form>";
            } else {
                echo "<div class='alert alert-warning' role='alert'>Book not found.</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Book ID is missing in URL.</div>";
        }
        ?>

    </div>

    <!-- Footer -->
    <footer class="bg-dark text-light text-center py-4">
        <div class="container">
            <p class="m-0">NamMau Bookstore &copy; 2024</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-XB4iNv5a1+xzv1xXXy09+Lo8pSLD1EZuxV3vEW+3Pgp0U0it7bAPdkcGnS0q5B9z"
        crossorigin="anonymous"></script>
</body>

</html>
