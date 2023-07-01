<?php
class products
{
    function __construct()
    {
    }

    function countAllProducts()
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM products";
        $result = $db->get_instance($select);
        return $result[0];
    }

    function updateStatus($id)
    {
        $db = new connect();
        $select = $this->getProductById($id);
        if ($select) {
            if ($select['status'] == 0) {
                $update = "update products set status = 1 where id=$id";
            } else {
                $update = "update products set status = 0 where id = $id";
            }
            $result = $db->exec($update);
            return $result;
        }
    }
    //phương thức phân trang
    function getAllProductsPage($type_id, $keyword)
    {
        $type_id = intval($type_id);
        $db = new connect();
        $select = "select * from products order by id asc";
        if ($type_id != 0 && $keyword != "") {
            $select = "select * from products where type_id=$type_id and name like '%$keyword%' order by id asc";
        } else if ($type_id != 0 && $keyword == "") {
            $select = "select * from products where type_id=$type_id order by id asc ";
        } else if ($keyword != "" && $type_id == 0) {
            $select = "select * from products where  name like '%$keyword%' order by id asc";
        } else {
        }
        $result = $db->get_list($select);
        return $result;
    }
    //phương thức đếm số lượng sản phẩm để phân trang
    function countProducts($keyword)
    {
        $db = new connect();
        $select = "select count(*) from products";
        if ($keyword != "") {
            $select = "select count(*) from products where  name like '%$keyword%'";
        }
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getProductById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE $id = id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }

    function getProductByType($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE type_id = $id";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }


    function upLoadImage()
    {
        //tạo dường dẫn lưu hình
        $dir = "./../Assets/img/";
        //lấy tên hình
        $file = $dir . basename($_FILES['image']['name']);
        //kiểm tra định dạng file
        $imageType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //kiểm tra up load thành công không

        // if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES['image']['tmp_name']);
        if ($check != false) {

            if (file_exists($file)) {

                return "image name already exists";
            }
            //kiểm tra size ảnh
            else if ($_FILES['image']['size'] > 500000) {

                return "images exceed 500kb";
            }
            //kiểm tra dduuoi mở rộng
            else
                    
                    if ($imageType !== "jpg" && $imageType !== "jpeg" && $imageType !== "png" && $imageType !== "gif") {

                return "file is not an image format";
            }
            //tiến hành đưa ảnh về thư mục
            else if (move_uploaded_file($_FILES['image']['tmp_name'], $file)) {
                return "success";
            } else {
                return "error";
            }
        } else {

            return "file image does not exist";
        }
    }
    function updateProduct($id, $name, $type_id, $price, $promotion, $image, $quantity, $description, $subId, $dateAdd, $expiry, $created_at)
    {
        $db = new connect();
        $query = "UPDATE products SET  name='$name',type_id=$type_id,price=$price,promotion=$promotion,pro_image='$image',quantity=$quantity,description='$description',sup_id=$subId,date_add='$dateAdd',expiry='$expiry',created_at='$created_at' WHERE id = $id";
        // $query="UPDATE products SET id=$idUpdate,name='$name',type_id=$type_id,price=$price,promotion=$promotion,pro_image='$image',quantity=$quantity,description='$description',created_at='$created_at' WHERE id = $id";
        $result = $db->exec($query);
        return $result;
    }

    function removeProduct($id)
    {
        $db = new connect();
        $query = "delete from products where id = $id ";
        $db->exec($query);
    }

    function removeProductByType($type_id)
    {
        $db = new connect();
        $query = "delete from products where type_id = $type_id ";
        $db->exec($query);
    }

    function insertProduct($name, $type_id, $price, $promotion, $image, $quantity, $description, $supId, $dateAdd, $expiry, $dateCreate)
    {
        $db = new connect();
        $query = "INSERT INTO products(id, name, type_id, price, promotion, pro_image, quantity, description, sup_id,date_add, expiry, created_at, status) 
        VALUES (null,'$name',$type_id,$price,$promotion,'$image',$quantity,'$description',$supId,'$dateAdd','$expiry','$dateCreate',1)";
        $result = $db->exec($query);
        return $result;
    }

    function getStatistical($month, $year)
    {
        $db = new connect();
        $select = "SELECT a.name, sum(b.quantity) as quantity from products a, orderdetails b , orders c WHERE a.id=b.pro_id and c.order_id = b.order_id and month(c.date_create)=$month and  year(c.date_create)= $year GROUP BY a.name";
        $result = $db->get_list($select);
        return $result;
    }





    function countAllType()
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM protypes";
        $result = $db->get_instance($select);
        return $result[0];
    }
    //phương thức phân trang
    function getAllType()
    {
        $db = new connect();
        $select = "select * from protypes";

        $result = $db->get_list($select);
        return $result;
    }
    //phương thức đếm số lượng sản phẩm để phân trang
    function countType($keyword)
    {
        $db = new connect();
        $select = "select count(*) from protypes";
        if ($keyword != "") {
            $select = "select count(*) from protypes where  type_name like '%$keyword%'";
        }
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getTypeById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM protypes WHERE type_id =$id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }




    function updateType($id, $idUpdate, $name)
    {
        $db = new connect();
        $query = "update protypes set type_id=$idUpdate, type_name='$name'";
        // $query="UPDATE products SET id=$idUpdate,name='$name',type_id=$type_id,price=$price,promotion=$promotion,pro_image='$image',quantity=$quantity,description='$description',created_at='$created_at' WHERE id = $id";
        $db->exec($query);
    }

    function removeType($id)
    {
        $db = new connect();
        $query = "delete from protypes where type_id = $id ";
        // $query="UPDATE products SET id=$idUpdate,name='$name',type_id=$type_id,price=$price,promotion=$promotion,pro_image='$image',quantity=$quantity,description='$description',created_at='$created_at' WHERE id = $id";
        $db->exec($query);
    }

    function insertType($type_name)
    {
        $db = new connect();
        $query = "INSERT INTO protypes(type_id, type_name)
         VALUES (null,'$type_name')";
        $db->exec($query);
    }
    function getAllSupplier()
    {
        $db = new connect();
        $select = "select *from suppliers";
        $result = $db->get_list($select);
        return $result;
    }
    function getProductNew()
    {
        $db = new connect();
        $select = "SELECT * FROM products ORDER BY id DESC LIMIT 1";
        $result = $db->get_instance($select);
        return $result;
    }

    function checkIsColum($nameTable, $nameColumn)
    {
        $db = new connect();
        $check = "DESCRIBE $nameTable $nameColumn";
        $result = $db->get_list($check);
        return $result->fetchAll();
    }

    function addColumProperty($arrProperty)
    {
        $db = new connect();

        foreach ($arrProperty  as $key => $value) {
            $check = $this->checkIsColum("propertys", $value);

            if (count($check) <= 0) {
                $addColumn = "ALTER TABLE propertys ADD COLUMN $value VARCHAR(20) after image";
                $db->exec($addColumn);
            }
        }
        return true;
    }

    function insertProductProperty($prod_id, $sku, $imageProductProperty, $price, $promotion, $quantity, $dateCreate, $props)
    {
        $db = new connect();

        // convert $props to SQL string
        $propKey = '';
        $propValue = '';
        foreach ($props as $key => $value) {
            $propKey .= "`$key`,";
            $propValue .= "'$value',";
        }
        $propKey = rtrim($propKey, ",");
        $propValue = rtrim($propValue, ",");


        $insert = "INSERT INTO `propertys`(`id`, `prod_id`, `SKU`, $propKey, `image`, `price`, `promotion`, `quantity`, `status`,`create_at`) VALUES (null,$prod_id,$sku,$propValue,'$imageProductProperty',$price,$promotion,$quantity,0,'$dateCreate')";

        $result = $db->exec($insert);
        return $result;
    }
    function getProductPropertyById($id)
    {
        $db = new connect();
        $select = "SELECT * FROM `propertys` WHERE prod_id = $id";
        $result = $db->get_list($select);
        return $result;
    }
    function getProductPropertyBySKU($sku)
    {
        $db = new connect();
        $select = "SELECT * FROM `propertys` WHERE SKU = $sku";
        $result = $db->get_instance($select);
        return $result;
    }
    function updateProductProperty($sku,$price,$promotion,$quantity,$image) {
        $db = new connect();
        $update = "UPDATE `propertys`SET `price`=$price,`promotion`=$promotion,`quantity`=$quantity,`image`='$image'  WHERE SKU = $sku";
        $result = $db->exec($update);
        return $result;
    }
}
