<?php 

    define('DB_SERVER', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_NAME', 'it24');
    
    class DB_con {

        function __construct() {
            $conn = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
            $this->dbcon = $conn;

            if (mysqli_connect_errno()) {
                echo "ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้ : " . mysqli_connect_error();
            }
        }

        // public function insert($name, $price, $description, $category_id, $image, $created_at, $updated_at) {
        //     $result = mysqli_query($this->dbcon, "INSERT INTO products(name, price, description, category_id, image, created_at, updated_at) VALUES('$name', '$price', '$description', '$category_id', '$image', $created_at, $updated_at)");
        //     return $result;
        // }

        public function fetchdata() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM products JOIN categories
            ON products.category_id = categories.category_id ;");
            return $result;
        }
        public function fetchdata1() {
            $result = mysqli_query($this->dbcon, "SELECT * FROM products
            RIGHT JOIN categories
            ON products.category_id = categories.category_id AND categories.name ;");
            return $result;
        }

        public function fetchonerecord($product_id) {
            $result = mysqli_query($this->dbcon, "SELECT * FROM products WHERE id = '$product_id'");
            return $result;
        }

        public function update($name, $price, $description, $category_id,	$image, $product_id, $created_at, $updated_at) {
            $result = mysqli_query($this->dbcon, "UPDATE products SET 
                name = '$name',
                price = '$price',
                description = '$description',
                category_id = '$category_id',
                image = '$image',
                created_at = date(),
                updated_at = date(),
                WHERE id = '$product_id'
            ");
            return $result;
        }

        public function delete($product_id) {
            $deleterecord = mysqli_query($this->dbcon, "DELETE FROM products WHERE id = '$product_id'");
            return $deleterecord;
        }

    }
    

?>