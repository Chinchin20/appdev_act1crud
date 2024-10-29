<?php
// create.php
include 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $query = "INSERT INTO Products (name, description, price, quantity, barcode, created_at, updated_at) VALUES (:name, :description, :price, :quantity, :barcode, NOW(), NOW())";
        $stmt = $con->prepare($query);

        $name = htmlspecialchars(strip_tags($_POST['name']));
        $description = htmlspecialchars(strip_tags($_POST['description']));
        $price = htmlspecialchars(strip_tags($_POST['price']));
        $quantity = htmlspecialchars(strip_tags($_POST['quantity']));
        $barcode = htmlspecialchars(strip_tags($_POST['barcode']));

        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':barcode', $barcode);

        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Product was created.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to create product.</div>";
        }
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container-form {
            max-width: 700px;
            margin: 30px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom { border-radius: 4px; font-size: 14px; padding: 8px; }
        .btn-save { background-color: #113f67; color: white; border: none; }
        .btn-save:hover { background-color: #79c2d0; }
        .btn-danger { background-color: #38598b; color: white; border: none; }
        .btn-danger:hover { background-color: #79c2d0; }
    </style>
</head>
<body>
    <div class="container container-form">
        <div class="page-header">
            <h1>Create Product</h1>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
            <div class='form-group'>
                <label>Name</label>
                <input type='text' name='name' class='form-control' required />
            </div>
            <div class='form-group'>
                <label>Description</label>
                <textarea name='description' class='form-control' required></textarea>
            </div>
            <div class='form-group'>
                <label>Price</label>
                <input type='number' step='0.01' name='price' class='form-control' required />
            </div>
            <div class='form-group'>
                <label>Quantity</label>
                <input type='number' name='quantity' class='form-control' required />
            </div>
            <div class='form-group'>
                <label>Barcode</label>
                <input type='text' name='barcode' class='form-control' required />
            </div>
            <div class='form-group'>
                <input type='submit' value='Save' class='btn btn-custom btn-save' />
                <a href='read.php' class='btn btn-primary btn-custom '>Product List</a>
            </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
