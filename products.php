<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Jika tidak login, redirect ke halaman login
    exit();
}

$title = 'Product';

require_once 'app/ProductController.php';

// Membuat instance dari ProductController
$productController = new ProductController();

// Mendapatkan semua produk
$products = $productController->getAllProducts();

require 'template/header.php';

?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><i class="fas fa-store"></i> Products</h1>
        <a href="javascript:void(0);" onclick="printReport()" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
        </a>
    </div>

    <!-- Content Row -->
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-table"></i> Table Product</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <a href="create-product.php" class="btn btn-primary mb-2 btn-sm">
                <i class="fas fa-plus"></i> Add Product
            </a>

            <div class="table-responsive">
                <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Thumbnail</th>
                            <th>Product</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1 ?>
                        <?php foreach ($products as $product) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><img src="assets/img/thumbnails/<?= $product['thumbnail'] ?>" width="100"></td>
                                <td><?= $product['name'] ?></td>
                                <td><?= $product['category'] ?></td>
                                <td><?= "Rp. " . number_format($product['price'], 0, ',', '.') ?></td>
                                <td><?= $product['created_at'] ?></td>
                                <td class="text-center" width="15%">
                                    <button class="btn btn-success btn-sm" onclick="editProduct(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                    <button class="btn btn-danger btn-sm" onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-trash-alt"></i> Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    <script>
        function editProduct(productId) {
            window.location.href = 'edit-product.php?id=' + productId;
        }

        function deleteProduct(productId) {
            if (confirm("Are you sure you want to delete this product?")) {
                window.location.href = 'delete-product.php?id=' + productId;
            }
        }

        function printReport() {
            var table = document.getElementById('dataTable').cloneNode(true); // Clone tabel
            var rows = table.getElementsByTagName('tr');

            // Menyembunyikan kolom action
            for (var i = 0; i < rows.length; i++) {
                rows[i].deleteCell(-1); // Menghapus kolom terakhir (Action)
            }

            var win = window.open('', '', 'height=400,width=600');
            win.document.write('<html><head><title>Product Report</title>');
            win.document.write('</head><body>');
            win.document.write('<h1>Product Report</h1>');
            win.document.write(table.outerHTML); // Menggunakan tabel tanpa kolom Action
            win.document.write('</body></html>');
            win.document.close();
            win.print();
        }
    </script>
    <?php require 'template/footer.php'; ?>
