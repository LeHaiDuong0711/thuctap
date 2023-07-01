<?php 
class orders{
    function __construct()
    {
        
    }

    function getOrders($userId,$status)
    {
        $db = new connect();
        if($status==null){
            $select = "select * from orders where user_id = $userId and hide = 0 ORDER BY order_id DESC";
        } else {
            $select = "select * from orders where user_id = $userId and status =$status and hide = 0  ORDER BY order_id DESC";
        }
        $result = $db->get_list($select);
        return $result;
    }
    function getOrderDetails($orderId)
    {
        $db = new connect();
        $select = "SELECT *
        FROM orderdetails
        WHERE order_id IN (0, $orderId)";
        $result = $db->get_list($select);
        
        return $result;
    }
    function updateStatus($id, $status)
    {
        $db = new connect();
        $query = "update orders set status =$status where order_id=$id ";
        $db->exec($query);
    }


}


?>