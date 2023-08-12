<?php

include_once('../service/connection.php');
include_once('../service/function.php');

if (isset($_REQUEST['update_id'])) {
    try {
        $id = $_REQUEST['update_id'];
        $select_stmt = $db->prepare('SELECT * FROM products WHERE product_id = :id');
        $select_stmt->bindParam(":id", $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        extract($row);
    } catch (PDOException $e) {
        $e->getMessage();
    }
}

if (isset($_REQUEST['btn_update'])) {
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

        $path = "../upload/" . $image_file;
        $directory = "../upload/"; // set uplaod folder path for upadte time previos file remove and new file upload for next use

        if ($image_file) {
            if ($type == "image/jpg" || $type == 'image/jpeg' || $type == "image/png" || $type == "image/gif") {
                if (!file_exists($path)) { // check file not exist in your upload folder path
                    if ($size < 5000000) { // check file size 5MB
                        unlink($directory . $row['image']); // unlink functoin remove previos file
                        move_uploaded_file($temp, '../upload/' . $image_file); // move upload file temperory directory to your upload folder
                    } else {
                        $errorMsg = "Your file to large please upload 5MB size";
                    }
                } else {
                    $errorMsg = "File already exists... Check upload folder";
                }
            } else {
                $errorMsg = "Upload JPG, JPEG, PNG & GIF formats...";
            }
        } else {
            $image_file = $row['image']; // if you not select new image than previos image same it is it.
        }

        if (!isset($errorMsg)) {
            $update_stmt = $db->prepare("UPDATE products SET pro_name = :name_up, price = :price_up, description = :description_up, category_id = :category_id, image = :image_up, created_at = :created_at, updated_at = :updated_at WHERE product_id = :id");
            $update_stmt->bindParam(':name_up', $name);
            $update_stmt->bindParam(':price_up', $price);
            $update_stmt->bindParam(':description_up', $description);
            $update_stmt->bindParam(':category_id', $category_id);
            $update_stmt->bindParam(':image_up', $image_file);
            $update_stmt->bindParam(':created_at', $created_at);
            $update_stmt->bindParam(':updated_at', $updated_at);
            $update_stmt->bindParam(':id', $id);

            if ($update_stmt->execute()) {
                $updateMsg = "แก้ไขข้อมูลสำเร็จ";
                header("refresh:2;../index.php");
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
        if (isset($updateMsg)) {
        ?>
            <div class="alert alert-success">
                <strong><?php echo $updateMsg; ?></strong>
            </div>
        <?php } ?>
        <div class="row mt-5">
            <h2>แก้ไขข้อมูลสินค้า</h2>
        </div>
        <form method="post" action="" class="mt-5" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">ชื่อสินค้า</label>
                <input type="text" name="pro_name" class="form-control" id="name" value="<?php echo $pro_name; ?>">
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">ราคาสินค้า</label>
                <input type="text" name="price" class="form-control" id="price" value="<?php echo $price; ?>">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">รายละเอียดสินค้า</label>
                <textarea class="form-control" name="description" id="description" rows="3"><?php echo $description; ?>
                </textarea>
            </div>
            <div class="mb-3">
                <select class="form-select" name="category_id" aria-label="Default select example">

                    <?php
                    $fetchdata = new DB_con();
                    $sql = $fetchdata->fetchdata1();
                    while ($row = mysqli_fetch_array($sql)) {
                    ?>
                        <option value="<?php echo $row['category_id']; ?>" selected><?php echo $row['name']; ?></option>
                    <?php
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">รูปสินค้า</label>
                <input class="form-control" name="image" type="file" id="formFile">
            </div>
            <p>
                <img src="../upload/<?php echo $image; ?>" height="100" width="100" alt="">
            </p>
            <div class="mb-3">
                <input type="submit" name="btn_update" class="btn btn-success" value="อัพเดทข้อมูล">
                <a href="../index.php" class="btn btn-danger">ย้อนกลับ</a>
            </div>

        </form>
    </div>
    <script src="../node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>