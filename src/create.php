<?php

include_once('../service/connection.php');
include_once('../service/function.php');

if (isset($_REQUEST['btn_insert'])) {
    try {
        $name = $_REQUEST['pro_name'];
        $price = $_REQUEST['price'];
        $description = $_REQUEST['description'];
        $category_id = $_REQUEST['category_id'];
        $created_at = date("d-m-Y H:i:s");
        $updated_at = date("d-m-Y H:i:s");

        $image_file = $_FILES['image']['name'];
        $type = $_FILES['image']['type'];
        $size = $_FILES['image']['size'];
        $temp = $_FILES['image']['tmp_name'];

        $path = "../upload/" . $image_file; // set upload folder path

        if (empty($name)) {
            $errorMsg = "Please Enter name";
        } elseif (empty($price)) {
            $errorMsg = "Please Enter price";
        } elseif (empty($description)) {
            $errorMsg = "Please Enter description";
        } elseif (empty($category_id)) {
            $errorMsg = "Please Enter category";
        } else if (empty($image_file)) {
            $errorMsg = "please Select Image";
        } else if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
            if (!file_exists($path)) { // check file not exist in your upload folder path
                if ($size < 5000000) { // check file size 5MB
                    move_uploaded_file($temp, '../upload/' . $image_file); // move upload file temperory directory to your upload folder
                } else {
                    $errorMsg = "Your file too large please upload 5MB size"; // error message file size larger than 5mb
                }
            } else {
                $errorMsg = "File already exists... Check upload filder"; // error message file not exists your upload folder path
            }
        } else {
            $errorMsg = "Upload JPG, JPEG, PNG & GIF file formate...";
        }

        if (!isset($errorMsg)) {
            $stmt = $db->prepare('INSERT INTO products(pro_name, price, description, category_id, image, created_at, updated_at) VALUES (:fname, :fprice, :fdescription, :fcategory_id, :fimage, :fcreated_at, :fupdated_at)');
            $stmt->bindParam(':fname', $name);
            $stmt->bindParam(':fprice', $price);
            $stmt->bindParam(':fdescription', $description);
            $stmt->bindParam(':fcategory_id', $category_id);
            $stmt->bindParam(':fimage', $image_file);
            $stmt->bindParam(':fcreated_at', $created_at);
            $stmt->bindParam(':fupdated_at', $updated_at);

            if ($stmt->execute()) {
                $insertMsg = "ข้อมูลถูกบันทึกเรียบร้อยแล้ว";
                header('refresh:2;../index.php');
            }
        }
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบฐานข้อมูลร้าน IT Shop</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <?php
        if (isset($errorMsg)) {
        ?>
            <div class="alert alert-danger">
                <strong><?php echo $errorMsg; ?></strong>
            </div>
        <?php } ?>

        <?php
        if (isset($insertMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $insertMsg; ?></strong>
            </div>
        <?php } ?>
        <div class="row mt-5">
            <h2>เพิ่มสินค้า</h2>
        </div>
        <form method="post" action="" class="mt-5" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อสินค้า</label>
                <input type="text" name="pro_name" class="form-control" id="name">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคาสินค้า</label>
                <input type="text" name="price" class="form-control" id="price">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="description" id="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <select class="form-select" name="category_id" aria-label="Default select example">
                    <option selected>กรุณาเลือกประเภทสินค้า</option>
                    <?php
                    $fetchdata = new DB_con();
                    $sql = $fetchdata->fetchdata1();
                    while ($row = mysqli_fetch_array($sql)) {

                    ?>
                        <option value="<?php echo $row['category_id']; ?>"><?php echo $row['name']; ?></option>
                    <?php

                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">รูปสินค้า</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>
            <div class="mb-3">
                <input type="submit" name="btn_insert" class="btn btn-success" value="บันทึก">
                <a href="../index.php" class="btn btn-danger">ย้อนกลับ</a>
            </div>

        </form>
    </div>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>