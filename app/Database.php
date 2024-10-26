<?php

class Database
{
    private static $instance = null;
    private $connection;

    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $db_name = "e-toko";

    // Private constructor untuk mencegah inisialisasi dari luar
    private function __construct()
    {
        $this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->db_name);

        if (!$this->connection) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    // Mendapatkan instance dari koneksi database (singleton)
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    // Mendapatkan koneksi mysqli
    public function getConnection()
    {
        return $this->connection;
    }
}
