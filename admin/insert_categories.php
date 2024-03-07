<?php
include('../includes/connect.php');
if(isset($_POST['insert_cat'])){
    // Sanitize user input
    $category_title = mysqli_real_escape_string($con, $_POST['cat_title']);
    
    // Prepare and bind the statement
    $insert_query = "INSERT INTO `categories` (category_title) VALUES (?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, "s", $category_title);
    
    // Execute the statement
    $result = mysqli_stmt_execute($stmt);
    
    if($result){
        echo "<script>alert('Category has been inserted successfully')</script>";
    } else {
        // Handle error
        echo "Error: " . mysqli_error($con);
    }
    
    // Close statement
    mysqli_stmt_close($stmt);
}
?>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="cat_title" placeholder="Insert categories" aria-label="Categories" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <input type="submit" class="bg-info border-0 p-2 my-3" name="insert_cat" value="Insert Categories">
    </div>
</form>

