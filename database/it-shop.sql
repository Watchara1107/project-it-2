-- ตารางประเภทสินค้า
Create Table categories(
    category_id int(10) comment 'รหัสประเภทสินค้า' AUTO_INCREMENT,
    name varchar(255) comment 'ชื่อประเภทสินค้า',
    created_at datetime comment'วันที่บันทึกรายการ',
    updated_at datetime comment 'วันที่อัพเดทรายการ',
    Primary Key(category_id)
);

-- ตารางสินค้า
Create Table products(
    product_id int(10) comment 'รหัสสินค้า' AUTO_INCREMENT,
    pro_name varchar(255) comment 'ชื่อสินค้า',
    price varchar(255) comment 'ราคาสินค้า',
    description text comment 'รายละเอียดสินค้า',
    category_id int(10) comment 'รหัสประเภทสินค้า',
    image varchar(255) comment 'ภาพสินค้า',
    created_at datetime comment 'วันที่บันทึกรายการ',
    updated_at datetime comment 'วันที่อัพเดทรายการ',
    Primary Key(product_id),
    Foreign Key(category_id) REFERENCES categories(category_id)

);

--  ตาราง User
Create Table users(
    id int(10) comment 'รหัสประจำตัวผู้ใช้' AUTO_INCREMENT,
    name varchar(255) comment 'ชื่อ-นามสกุล',
    address varchar(255) comment 'ที่อยู่',
    phone varchar(13) comment 'เบอร์โทรศัพท์',
    email varchar(255) comment 'อีเมล์',
    username varchar(255) comment 'ชื่อเข้าใช้งานระบบ',
    password varchar(255) comment 'รหัสผ่านระบบ',
    created_at datetime comment 'วันที่บันทึกรายการ',
    updated_at datetime comment 'วันที่อัพเดทรายการ',
    Primary Key(id)

);