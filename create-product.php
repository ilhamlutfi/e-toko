<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak login, redirect ke halaman login
    exit();
}

$title = 'Create Product';

require_once 'app/ProductController.php';

// Membuat instance dari ProductController
$productController = new ProductController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Memanggil fungsi create dan memasukkan data form
    $productController->create($_POST);
}

require 'template/header.php';
?>

<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-store"></i> Products</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-plus"></i> Create Product</h6>
        </div>

        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="name" class="font-weight-bold">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="category" class="font-weight-bold">Category</label>
                    <select name="category" id="category" class="form-control" required>
                        <option value="" hidden>-- Select Category --</option>
                        <option value="Iphone">Iphone</option>
                        <option value="Android">Android</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price" class="font-weight-bold">Price</label>
                    <input type="number" class="form-control" id="price" name="price" min="0" required>
                </div>

                <div class="form-group">
                    <label for="image">Thumbnail Image <small>(Max 5 MB)</small></label><br>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" id="image" name="thumbnail" accept="image/*">
                        <label class="custom-file-label" for="image">Choose file...</label>
                    </div>
                    <div class="mt-1">
                        <img id="img-prev" src="" class="img-thumbnail img-preview"
                            width="100px" alt="">
                    </div>
                </div>

                <div class="float-right">
                    <button type="submit" class="btn btn-primary">Save Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require 'template/footer.php'; ?>
