<?php
include('../includes/connect.php');
if(isset($_POST['insert_cat'])){
    // Check if type_title is set and not empty
    if(isset($_POST['type_title']) && !empty(trim($_POST['type_title']))){
        // Sanitize user input
        $type_title = trim(mysqli_real_escape_string($con, $_POST['type_title']));
        
        // Prepare and bind the statement
        $insert_query = "INSERT INTO `type` (type_title) VALUES (?)";
        $stmt = mysqli_prepare($con, $insert_query);
        mysqli_stmt_bind_param($stmt, "s", $type_title);
        
        // Execute the statement
        $result = mysqli_stmt_execute($stmt);
        
        if($result){
            echo "<script>alert('Type has been inserted successfully')</script>";
        } else {
            // Handle error
            echo "Error: " . mysqli_error($con);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "<script>alert('Type title cannot be empty')</script>";
    }
}
?>

<form action="" method="post" class="mb-2">
    <div class="input-group w-90 mb-2">
        <span class="input-group-text bg-info" id="basic-addon1"><i class="fa-solid fa-receipt"></i></span>
        <input type="text" class="form-control" name="type_title" placeholder="Insert Types" aria-label="types" aria-describedby="basic-addon1">
    </div>
    <div class="input-group w-10 mb-2 m-auto">
        <button type="submit" class="bg-info p-2 my-3 border-0" name="insert_cat">Insert Types</button>
    </div>
</form>
