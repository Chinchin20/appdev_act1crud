<?php
// read.php
include 'config/database.php';

try {
    
    $query = "SELECT id, name, description, price, quantity, barcode, created_at, updated_at FROM Products ORDER BY created_at DESC";
    $stmt = $con->prepare($query);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $exception) {
    die('ERROR: ' . $exception->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List</title>
    <!-- Latest compiled and minified Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        .container-form {
            max-width: 1000px;
            margin: 50px auto;
            padding: 20px;
            background-color: #f2f2f2;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .btn-custom {
            border-radius: 4px;
            font-size: 12px;
            padding: 8px 12px; 
            margin: 0 4px; 
            display: inline-block; 
        }
        .btn-edit {
            background-color: #5dacbd;
            color: white;
            border: none;
        }
        .btn-edit:hover {
            background-color: #79c2d0;
        }
        .btn-danger {
            background-color: #24527a;
            color: white;
            border: none;
        }
        .btn-danger:hover {
            background-color: #79c2d0;
        }
        .btn-add {
            margin-bottom: 20px; 
        }
    </style>
</head>
<body>
    <div class="container container-form">
        <div class="page-header">
            <h1>Product List</h1>
        </div>
        <a href="create.php" class="btn btn-primary btn-custom btn-add">Add New Product</a>
        <table class='table table-hover table-responsive table-bordered'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Barcode</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['id']); ?></td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
                            <td><?php echo htmlspecialchars($product['price']); ?></td>
                            <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                            <td><?php echo htmlspecialchars($product['barcode']); ?></td>
                            <td><?php echo htmlspecialchars($product['created_at']); ?></td>
                            <td><?php echo htmlspecialchars($product['updated_at']); ?></td>
                            <td>
                                <a href='update.php?id=<?php echo $product['id']; ?>' class='btn btn-info btn-custom btn-edit'>Edit</a>
                                <a href='delete.php?id=<?php echo $product['id']; ?>' class='btn btn-danger btn-custom' onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" class="text-center">No products found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <!-- Latest compiled and minified Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
