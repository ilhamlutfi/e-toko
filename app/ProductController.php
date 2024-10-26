<?php

require_once 'Database.php';

class ProductController
{
    private $db;

    public function __construct()
    {
        // get connection database singleton
        $this->db = Database::getInstance()->getConnection();
    }

    // get all products
    public function getAllProducts()
    {
        $result = mysqli_query($this->db, "SELECT * FROM products");
        $products = [];

        while ($product = mysqli_fetch_assoc($result)) {
            $products[] = $product;
        }

        return $products;
    }

    // get product by id
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // create product
    public function create($data)
    {
        $name       = $this->sanitize($data['name']);
        $category   = $this->sanitize($data['category']);
        $price      = $this->sanitize($data['price']);

        // Handle upload thumbnail
        $thumbnail = null;
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
            $thumbnail = $this->uploadThumbnail($_FILES['thumbnail']);
        }

        $stmt = $this->db->prepare("INSERT INTO products (thumbnail, name, category, price) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $thumbnail, $name, $category, $price);

        if ($stmt->execute()) {
            echo "<script>alert('Product created successfully!'); window.location='products.php'</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    // update product
    public function update($id, $data)
    {
        $name     = $this->sanitize($data['name']);
        $category = $this->sanitize($data['category']);
        $price    = $this->sanitize($data['price']);

        // Mendapatkan thumbnail saat ini dari database
        $currentThumbnail = $this->getCurrentThumbnail($id);

        // Handle upload thumbnail
        $thumbnail = $currentThumbnail; // Default ke thumbnail saat ini
        if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == UPLOAD_ERR_OK) {
            // Jika ada thumbnail baru yang diunggah
            $thumbnail = $this->uploadThumbnail($_FILES['thumbnail']);
        }

        // Mengupdate data produk
        $stmt = $this->db->prepare("UPDATE products SET thumbnail = ?, name = ?, category = ?, price = ? WHERE id = ?");
        $stmt->bind_param("ssssi", $thumbnail, $name, $category, $price, $id);

        if ($stmt->execute()) {
            // Hapus thumbnail lama jika ada yang baru diunggah
            if ($thumbnail !== $currentThumbnail && $currentThumbnail) {
                unlink('assets/img/thumbnails/' . $currentThumbnail);
            }
            echo "<script>alert('Product updated successfully!'); window.location='products.php'</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }


    public function delete($id)
    {
        // Mendapatkan thumbnail saat ini dari database
        $currentThumbnail = $this->getCurrentThumbnail($id);

        // Menghapus produk dari database
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Hapus thumbnail dari folder jika ada
            if ($currentThumbnail) {
                $thumbnailPath = 'assets/img/thumbnails/' . $currentThumbnail;
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath);
                }
            }
            echo "<script>alert('Product deleted successfully!'); window.location='products.php'</script>";
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
    }

    private function getCurrentThumbnail($id)
    {
        $stmt = $this->db->prepare("SELECT thumbnail FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        return $product ? $product['thumbnail'] : null;
    }

    // upload thumbnail
    private function uploadThumbnail($file)
    {
        $uploadDir = 'assets/img/thumbnails/';
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetFilePath = $uploadDir . $fileName;

        // Validasi tipe file
        $fileType = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileType, $allowedTypes)) {
            echo "Error: Only JPG, JPEG, and PNG files are allowed.";
            return null;
        }

        // Validasi ukuran file (5MB)
        $maxSize = 5 * 1024 * 1024; // 5 MB dalam byte
        if ($file['size'] > $maxSize) {
            echo "Error: File size should not exceed 5 MB.";
            return null;
        }

        // Membuat folder jika belum ada
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Memindahkan file yang diunggah ke folder tujuan
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            return $fileName;
        } else {
            echo "Error: There was an error uploading the file.";
            return null;
        }
    }

    // filter input
    private function sanitize($data)
    {
        return htmlspecialchars(strip_tags($data));
    }
}
