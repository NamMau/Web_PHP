<?php
include('../includes/connect.php');

if(isset($_POST['insert_book'])){
    // Xử lý thêm loại "category"
    $book_title = isset($_POST['book_title']) ? $_POST['book_title'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $book_category = isset($_POST['book_categories']) ? $_POST['book_categories'] : '';
    $book_type = isset($_POST['book_type']) ? $_POST['book_type'] : '';
    $book_price = isset($_POST['book_price']) ? $_POST['book_price'] : '';
    $book_image = isset($_FILES['book_image']['name']) ? $_FILES['book_image']['name'] : '';

    //accessing image tmp name
    $temp_image = isset($_FILES['book_image']['tmp_name']) ? $_FILES['book_image']['tmp_name'] : '';

    //checking empty
    if($book_title == '' or $description == '' or $book_category == '' or $book_type == '' or $book_price == '' or $book_image == ''){
        echo "<script>alert('Please fill all the available fields')</script>";
        exit();
    } else {
        move_uploaded_file($temp_image, "./book_images/$book_image");

        // Prepare and bind SQL statement
        $stmt = $con->prepare("INSERT INTO `book` (book_title, book_description, category_id, type_id, book_image, book_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiiis", $book_title, $description, $book_category, $book_type, $book_image, $book_price);

        // Execute SQL statement
        $result_query = $stmt->execute();
        
        // Check if insertion was successful
        if($result_query){
            echo "<script>alert('Successfully inserted the book')</script>";
        } else {
            echo "<script>alert('Failed to insert the book')</script>";
        }
    }
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Books by admin</title>
    <!-- bootstrap css link-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--bootstrap js link-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
   
    <!--font awesome link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/brands.min.css" integrity="sha512-8RxmFOVaKQe/xtg6lbscU9DU0IRhURWEuiI0tXevv+lXbAHfkpamD4VKFQRto9WgfOJDwOZ74c/s9Yesv3VvIQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   
    <!-- css file-->
    <link rel="stylesheet" href="../style.css">
</head>
<body class="bg-light">
    <div class="container mt-3">
        <h1 class="text-center">Insert Books</h1>
        <!--form-->
        <form action="" method="post" enctype="multipart/form-data">
            <!-- title -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="book_title" class="form-label">Book title</label>
                <input type="text" name="book_title" id="book_title" class="form-control" placeholder="Enter book title" autocomplete="off" required="required">
            </div>

            <!-- description -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="description" class="form-label">Description</label>
                <input type="text" name="description" id="description" class="form-control" placeholder="Enter book description" autocomplete="off" required="required">
            </div>

            <!--categories-->>
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="book_categories" id="" class="form-select">
                    <option value="">Select a category</option>
                    <?php 
                        $select_query="Select * from `categories`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $category_title=$row['category_title'];
                            $category_id=$row['category_id'];
                            echo "<option value='$category_id'>$category_title</option>";
                        }
                    ?>

                </select>
            </div>

            <!-- type -->
            <div class="form-outline mb-4 w-50 m-auto">
                <select name="book_type" id="" class="form-select">
                    <option value="">Select a type</option>
                    <?php 
                        $select_query="Select * from `type`";
                        $result_query=mysqli_query($con,$select_query);
                        while($row=mysqli_fetch_assoc($result_query)){
                            $type_title=$row['type_title'];
                            $type_id=$row['type_id'];
                            echo "<option value='$type_id'>$type_title</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- image -->
            <div class="form-outline mb-4 w-50 m-auto">
                <label for="book_image" class="form-label">Book Image</label>
                <input type="file" name="book_image" id="book_image" class="form-control" required="required">
            </div>

             <!--price-->>
             <div class="form-outline mb-4 w-50 m-auto">
             <label for="book_price" class="form-label">Price</label>
                <input type="text" name="book_price" id="book_price" class="form-control" placeholder="Enter price" autocomplete="off" required="required">
            </div>

             <!--button submit-->>
             <div class="form-outline mb-4 w-50 m-auto">
                <input type="submit" name="insert_book" class="btn btn-info mb-3 px-5" value="Insert Books">
            </div>
        </form>
    </div>
    
</body>
</html>