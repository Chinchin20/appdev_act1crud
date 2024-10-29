<?php
// update.php
include 'config/database.php';

$id = $name = $description = $price = $quantity = $barcode = "";
$updateMode = false;

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = htmlspecialchars(strip_tags($_GET['id']));

    try {
        
        $query = "SELECT id, name, description, price, quantity, barcode FROM Products WHERE id = :id";
        $stmt = $con->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            $name = $name;
            $description = $description;
            $price = $price;
            $quantity = $quantity;
            $barcode = $barcode;
            $updateMode = true;
        } else {
            echo "<div class='alert alert-danger'>Product not found.</div>";
            exit;
        }
    } catch (PDOException $exception) {
        die('ERROR: ' . $exception->getMessage());
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        
        $query = "UPDATE Products SET name = :name, description = :description, price = :price, quantity = :quantity, barcode = :barcode, updated_at = NOW() WHERE id = :id";
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
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        
        if ($stmt->execute()) {
            echo "<div class='alert alert-success'>Product was updated.</div>";
        } else {
            echo "<div class='alert alert-danger'>Unable to update product.</div>";
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
    <title>Update Product</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container-form {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom { border-radius: 4px; font-size: 14px; padding: 8px; }
        .btn-save { background-color: #5dacbd; color: white; border: none; }
        .btn-save:hover { background-color: #79c2d0; }
        .btn-danger { background-color: #24527a; color: white; border: none; }
        .btn-danger:hover { background-color: #79c2d0; }
    </style>
</head>
<body>
    <div class="container container-form">
        <div class="page-header">
            <h1>Update Product</h1>
        </div>
        <?php if ($updateMode): ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $id; ?>" method="post">
            <div class='form-group'>
                <label>Name</label>
                <input type='text' name='name' class='form-control' value='<?php echo htmlspecialchars($name); ?>' required />
            </div>
            <div class='form-group'>
                <label>Description</label>
                <textarea name='description' class='form-control' required><?php echo htmlspecialchars($description); ?></textarea>
            </div>
            <div class='form-group'>
                <label>Price</label>
                <input type='number' step='0.01' name='price' class='form-control' value='<?php echo htmlspecialchars($price); ?>' required />
            </div>
            <div class='form-group'>
                <label>Quantity</label>
                <input type='number' name='quantity' class='form-control' value='<?php echo htmlspecialchars($quantity); ?>' required />
            </div>
            <div class='form-group'>
                <label>Barcode</label>
                <input type='text' name='barcode' class='form-control' value='<?php echo htmlspecialchars($barcode); ?>' required />
            </div>
            <div class='form-group'>
                <input type='submit' value='Save Changes' class='btn btn-info btn-custom btn-save' />
                <a href='read.php' class='btn btn-primary btn-custom'>Back to List</a>
            </div>
        </form>
        <?php else: ?>
            <div class='alert alert-danger'>Product not found.</div>
        <?php endif; ?>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
