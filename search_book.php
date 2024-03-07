<?php
include('includes/connect.php');

function searchBooks($con, $keyword) {
    // Escape the keyword to prevent SQL injection
    $keyword = mysqli_real_escape_string($con, $keyword);

    // Construct the SQL query
    $query = "SELECT * FROM `book` WHERE `book_title` LIKE '%$keyword%' OR `book_description` LIKE '%$keyword%'";

    // Execute the query
    $result = mysqli_query($con, $query);

    // Check if there are any results
    if (mysqli_num_rows($result) > 0) {
        echo "<div class='row'>";
        while ($row = mysqli_fetch_assoc($result)) {
            $book_id = $row['book_id'];
            $book_title = $row['book_title'];
            $book_description = $row['book_description'];
            $book_image = $row['book_image'];
            $book_price = $row['book_price'];
            $category_id = $row['category_id'];
            $type_id = $row['type_id'];
            
            // Display the book information
            echo "<div class='col-md-4 mb-2'>
                        <div class='card'>
                            <img src='./admin/book_images/$book_image' class='card-img-top' alt='$book_title'>
                            <div class='card-body'>
                                <h5 class='card-title'>$book_title</h5>
                                <p class='card-text'>$book_description</p>
                                <a href='#' class='btn btn-info'>Add to cart</a>
                                <a href='#' class='btn btn-secondary'>View more</a>
                            </div>
                        </div>
                    </div>";
        }
        echo "</div>";
    } else {
        // No books found
        echo "No books found matching the search criteria.";
    }
}

// Example usage:
$searchKeyword = isset($_GET['search']) ? $_GET['search'] : '';
searchBooks($con, $searchKeyword);
?>
