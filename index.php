<?php 

    require_once('service/connection.php');

    if (isset($_REQUEST['delete_id'])) {
        $id = $_REQUEST['delete_id'];

        $select_stmt = $db->prepare('SELECT * FROM products WHERE product_id = :id');
        $select_stmt->bindParam(':id', $id);
        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC);
        unlink("upload/".$row['image']); // unlin functoin permanently remove your file

        // delete an original record from db
        $delete_stmt = $db->prepare('DELETE FROM products WHERE product_id = :id');
        $delete_stmt->bindParam(':id', $id);
        $delete_stmt->execute();

        header("Location: index.php");
    }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ระบบฐานข้อมูลร้าน IT Shop</title>
  <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>

<body>
  <div class="container">
    <div class="row mt-5">
      <h2>ระบบฐานข้อมูลร้าน IT Shop</h2>
    </div>
    <a href="src\create.php" class="btn btn-primary mt-5"> เพิ่มสินค้า</a>
    <table class="table mt-5">
      <thead>
        <tr>
          <th scope="col">รหัสสินค้า</th>
          <th scope="col">ชื่อสินค้า</th>
          <th scope="col">รูปสินค้า</th>
          <th scope="col">ราคา</th>
          <th scope="col">รายละเอียด</th>
          <th scope="col">ประเภทสินค้า</th>
          <th scope="col">วันที่บันทึก</th>
          <th scope="col">วันที่อัพเดท</th>
          <th scope="col">การจัดการ</th>
        </tr>
      </thead>
      <tbody>
        <?php

        include_once('service/function.php');
        $fetchdata = new DB_con();
        $sql = $fetchdata->fetchdata();
        while ($row = mysqli_fetch_array($sql)) {

        ?>
          <tr>
            <th scope="row"><?php echo $row['product_id']; ?></th>
            <td><?php echo $row['pro_name']; ?></td>
            <td><img src="upload/<?php echo $row['image']; ?>" width="100px" height="100px" alt=""></td>
            <td><?php echo $row['price']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['created_at']; ?></td>
            <td><?php echo $row['updated_at']; ?></td>
            <td>
              <a href="src/edit.php?update_id=<?php echo $row['product_id']; ?>" class="btn btn-warning"> แก้ไข </a>
              <a href="?delete_id=<?php echo $row['product_id']; ?>" class="btn btn-danger"> ลบ </a>
            </td>
          </tr>
        <?php

        }
        ?>
      </tbody>
    </table>
  </div>
  <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script>
  <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
</body>

</html>