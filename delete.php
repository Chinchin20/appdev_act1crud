<?php
// delete.php
include 'config/database.php';

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = htmlspecialchars(strip_tags($_GET['id']));

    try {
        
        $query = "DELETE FROM Products WHERE id = :id";
        $stmt = $con->prepare($query);
        
        
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Product was deleted.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to delete product.</div>";
        }
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }

    
    header('Location: read.php');
    exit();
} else {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container-form {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f7f7f7;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom { border-radius: 4px; font-size: 14px; padding: 8px; }
        .btn-back { background-color: #5bc0de; color: white; border: none; }
        .btn-back:hover { background-color: #31b0d5; }
        .btn-danger { background-color: #d9534f; color: white; border: none; }
        .btn-danger:hover { background-color: #c9302c; }
    </style>
</head>
<body>
    <div class="container container-form">
        <div class="page-header">
            <h1>Delete Product</h1>
        </div>
        <a href='read.php' class='btn btn-info btn-custom btn-back'>Back to List</a>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
