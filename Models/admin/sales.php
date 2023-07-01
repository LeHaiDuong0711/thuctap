<?php
class sales
{

    function __construct()
    {
    }
    //  function insertOrder($order_id, $user_id, $firstName, $lastName, $phone, $note)
    // {

    //     $db = new connect();
    //     $date = new DateTime('now');
    //     $dateformat = $date->format('Y/m/d');
    //     $insert = "INSERT INTO orders(order_id,user_id,lastName,firstName,phone,total,note,date_create,status ) values($order_id,$user_id,'$lastName','$firstName','$phone',0,'$note','$dateformat',0)";
    //     $db->exec($insert);
    //     //sau khi insert đc mã hóa đơn rồi lấy ra mã hóa đơn vừa insert vào
    //     // $bill = $db->get_instance("select order_id from orders order by order_id desc limit 1");
    //     // return $bill[0];
    // }
    function countAllOrders()
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM orders";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function countOrdersToday()
    {
        $date = new DateTime("now");
        $dateCreate = $date->format('Y/m/d');
        $db = new connect();
        $select = "SELECT COUNT(*) FROM orders where date_create = '$dateCreate' ";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getAllOrders()
    {
        // $id_order = (int) $keyword;
        $db = new connect();
        $select = "select * from orders ";
        $result = $db->get_list($select)->fetchAll();
        return $result;
    }
    function getAllOrdersPage($keyword)
    {
        // $id_order = (int) $keyword;
        $db = new connect();
        $select = "select * from orders order by order_id desc";
        if ($keyword != "") {
            $select = "select * from orders where  order_id = $keyword order by order_id desc";
        }
        $result = $db->get_list($select);
        return $result;
    }
    //phương thức đếm số lượng sản phẩm để phân trang
    function countOrders($keyword)
    {
        $db = new connect();
        $select = "select count(*) from orders";
        if ($keyword != "") {
            $select = "select count(*) from orders where  order_id = $keyword";
        }
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getOrderById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM orders WHERE  order_id = $id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result;
    }
    function updateOrder($id,  $userId, $fullName, $phone, $status, $note, $created_at)
    {
        $id = intval($id);
        $userId = intval($userId);
        $db = new connect();
        $query = "update orders set  user_id = $userId,  fullName='$fullName',  phone=$phone,  note='$note',  date_create='$created_at',status =$status where order_id=$id     ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
        // $query = "update orderdetails set order_id=$idUpdate where order_id=$id      ";
        // $db->exec($query);
    }
    function updateTotalOrder($orderId, $subTotal)
    {
        $db = new connect();
        $query = "update orders set total=$subTotal where order_id=$orderId     ";
        $db->exec($query);
    }

    function removeOrder($id)
    {
        $db = new connect();
        $query = "delete from orderdetails where order_id = $id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
        $query = "delete from orders where order_id = $id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }

    function removeOrderByUser($user_id)
    {
        $db = new connect();
        $query = "delete from orders where user_id = $user_id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }
    function updateStatus($id, $status)
    {
        $db = new connect();
        $date = new DateTime('now');
        $dateformat = $date->format('Y/m/d H:i:s');
        echo $dateformat;
        if ($status == 0) {
            $query = "update orders set status =$status, reset_date='$dateformat' where order_id=$id ";
        } else if ($status == 1) {
            $query = "update orders set status =$status, delivery_date='$dateformat' where order_id=$id ";
        } else if ($status == 2) {
            $query = "update orders set status =$status, received_date='$dateformat' where order_id=$id ";
        } else if ($status == 3) {
            $query = "update orders set status =$status, cancellation_date='$dateformat' where order_id=$id ";
        }
 
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }






    function countAllOrderDetail($orderId)
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM orderdetails where order_id =$orderId";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getAllOrderDetail($orderId)
    {
        // $id_order = (int) $keyword;
        $db = new connect();
        $select = "select * from orderdetails where order_id =$orderId  order by order_id asc";
        $result = $db->get_list($select)->fetchAll();
        return $result;
    }
    function getAllOrderDetailPage($orderId)
    {
        // $id_order = (int) $keyword;
        $db = new connect();
        $select = "select * from orderdetails where order_id =$orderId  order by order_id asc";
        $result = $db->get_list($select);
        return $result;
    }

    function getOrderDetailById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM orderdetails WHERE  id = $id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }
    function updateOrderDetail($id, $idUpdate, $quantity, $total)
    {
        $db = new connect();
        $query = "update orderdetails set order_id=$idUpdate, quantity = $quantity,  total=$total where id=$id     ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }

    function removeOrderDetail($id)
    {
        $db = new connect();
        $query = "delete from orderdetails where id = $id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }

    function removeOrderDetailByOrderId($order_id)
    {
        $db = new connect();
        $query = "delete from orderdetails where order_id = $order_id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }
    function updateHide($id)
    {
        $db = new connect();
        $select = $this->getOrderById($id);
        if ($select) {
            if ($select['hide'] == 0) {
                $update = "update orders set hide = 1 where order_id=$id";
            } else {
                $update = "update orders set hide = 0 where order_id = $id";
            }
            $result = $db->exec($update);
            return $result;
        }
    }

    function totalSalesToday()
    {
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $db = new connect();
        $select = "SELECT SUM(total) FROM orders WHERE date_create = '$dateCreate'";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function totalRevenue()
    {
        $db = new connect();
        $select = "SELECT SUM(total) FROM orders";
        $result = $db->get_instance($select);
        return $result[0];
    }

    function totalSalesByMonthYear($year)
    {

        $db = new connect();
        $select = "SELECT MONTH(date_create) AS month, COUNT(*) AS totalSales , sum(total) as totalRevenue
        FROM orders
        WHERE YEAR(date_create) = $year
        GROUP BY MONTH(date_create)";
        $result = $db->get_list($select);
        return $result;
    }
}
