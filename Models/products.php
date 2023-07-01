<?php
class products
{
    function __construct()
    {
    }

    function  getAllProducts()
    {

        //b1 kết nối database
        $db = new connect();
        //b2 viết truy vấn;
        $select = "SELECT *FROM products order by id ASC ";
        $result = $db->get_list($select);
        return $result;
    }

    function get3NewProductsByTypeID($type_id,$id)
    {


        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE id<>$id and $type_id = type_id and status = 0 ORDER BY created_at DESC LIMIT 0,3";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result;
    }

    // function getAllNewProducts()
    // {

    //     //b1 ket noi data
    //     $db = new connect();
    //     // b2 truy van
    //     $select = "SELECT * FROM products ORDER BY id DESC LIMIT 0,9";
    //     //ai thuc hien select
    //     $result = $db->get_list($select);
    //     return $result;
    // }

    function getProductsTopSellingByType($type_id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "select a.pro_id, b.name, b.type_id,b.price,b.promotion,b.pro_image,b.quantity,b.description,b.created_at, sum(a.quantity) as subquantity from orderdetails a, products b WHERE a.pro_id = b.id and type_id = $type_id and status = 0 GROUP BY a.pro_id ORDER BY subquantity DESC  limit 3 ";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result;
    }

    function getProductById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE $id = id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result;
    }
    function getProductsByType($type_id)
    {


        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE $type_id = type_id ";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result; //kết quả được lấy về 12 sản phẩm

    }

    function getFeaturedFruit()
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE feature = 1 AND type_id = 1 LIMIT 3";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }

    function getFeaturedCake()
    {
        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE feature = 1 AND type_id = 2 LIMIT 3";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }
    function getFeaturedVegetable()
    {
        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM products WHERE feature = 1 AND type_id = 3 LIMIT 3";
        //ai thuc hien select
        $result = $db->get_list($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }




    //phương thức đếm số lượng sản phẩm để phân trang
    function countProducts($type_id, $keyword)
    {

        $db = new connect();
        $select = "select count(*) from products";
        if (($type_id != 0 && $keyword != "")) {
            $select = "select count(*) from products where type_id=$type_id and name like '%$keyword%'";
        } else if ($type_id != 0) {
            $select = "select count(*) from products where type_id=$type_id";
        } else if ($keyword != "") {
            $select = "select count(*) from products where  name like '%$keyword%'";
        } else if ($type_id == 0 && $keyword == "") {
            $select = "select count(*) from products";
        }
        $result = $db->get_instance($select);
        return $result[0];
    }

    //phương thức phân trang
    function getAllProductsPage($type_id, $keyword)
    {
        // create a new DateTime object and add 14 days to it
        $currentDate = new DateTime();
        $currentDate->add(new DateInterval('P14D'));

        // format the date as a string
        $date = $currentDate->format('Y/m/d');

        $db = new connect();
        if ($type_id != 0 && $keyword != "") {
            $select = "select * from products where type_id in ($type_id) and name like '%$keyword%' and status = 0 and expiry > '$date' order by date_add DESC";
        } else if ($type_id != 0 && $keyword == "") {
            $select = "select * from products where type_id in ($type_id) and status = 0 and expiry > '$date' order by date_add DESC";
        } else if ($keyword != "" && $type_id == 0) {
            $select = "select * from products where  name like '%$keyword%' and status = 0 and expiry > '$date' order by date_add DESC";
        } else {
            $select = "select * from products where status =0 and expiry > '$date' order by date_add DESC";
        }
        $result = $db->get_list($select);
        return $result;
    }

    function getSupplier($id)
    {
        $db = new connect();
        $select = "select b.id, b.name, b.address, b.phone from products a,suppliers b where a.id = $id and a.sup_id = b.id";
        $result = $db->get_instance($select);
        return $result;
    }

    function getProductByFiled($data, $typesId, $keyword)
    {
        // create a new DateTime object and add 14 days to it
        $currentDate = new DateTime();
        $currentDate->add(new DateInterval('P14D'));

        // format the date as a string
        $date = $currentDate->format('Y/m/d');

        $db = new connect();

        if ($typesId != 0) {
            $typesId = implode(",", $typesId);
            switch ($data) {
                case 0:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%'and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 1:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%' and price<10000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 2:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%'and price BETWEEN 0 and 10000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 3:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%'and price BETWEEN 10000 and 50000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 4:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%'and price BETWEEN 50000 and 100000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 5:
                    $select = "SELECT * FROM `products` WHERE type_id in ($typesId) and name like '%$keyword%'and price >100000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
            }
        } else {

            switch ($data) {
                case 0:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%' and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 1:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%' and price<10000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 2:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%'and price BETWEEN 0 and 10000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 3:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%'and price BETWEEN 10000 and 50000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 4:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%'and price BETWEEN 50000 and 100000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
                case 5:
                    $select = "SELECT * FROM `products` WHERE name like '%$keyword%'and price >100000 and status = 0 and expiry > '$date' order by date_add DESC";
                    break;
            }
        }




        $result = $db->get_list($select);
        return $result;
    }

    
    
    
    function getProductProperty($id)
    {
        $db = new connect();

        $select = "select*from propertys where prod_id=$id";

        $result = $db->get_list($select);
        return $result;
    }
    function getProductPropertyById($id)
    {
        $db = new connect();
        $select = "SELECT * FROM `propertys` WHERE id = $id";
        $result = $db->get_instance($select);
        return $result;
    }
function getProductPropertyBySKU($sku)
    {
        $db = new connect();
        $select = "SELECT * FROM `propertys` WHERE SKU = $sku";
        $result = $db->get_instance($select);
        return $result;
    }

    function getProductOderByUser($userId, $prodId)
    {
        $db = new connect();
        $select = "SELECT a.user_id, b.pro_id,a.order_id
        FROM orders a
        INNER JOIN orderdetails b
        ON a.order_id = b.order_id WHERE a.user_id = $userId and b.pro_id = $prodId";
        $result = $db->get_list($select)->fetchAll();
        return $result;
    }
    function getProductByPropertyId($id) {
         $db = new connect();
         $select = "SELECT `prod_id` FROM `propertys` WHERE id =$id";
         $result = $db->get_instance($select);
        $result1 = $this->getProductById($result['prod_id']);
        return $result1;
    }
   
}
