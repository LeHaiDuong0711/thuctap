<?php class wishlist{
    function __construct()
    {
        
    }

    function addWishlist($user_id,$pro_id,$create_at){
        $db = new connect();
        $query = "INSERT INTO wishlists (id,user_id,pro_id,create_at) VALUES (null,$user_id,$pro_id,'$create_at')";
        $result = $db->exec($query);
        return $result;
     }


    function getWishlist($user_id,$pro_id){
        $db = new connect();
        $query = "SELECT * from wishlists where user_id= $user_id and pro_id=$pro_id";
        $result = $db->get_Instance($query);
       return $result;

    }

    function getWishlistByUser($user_id){
        $db = new connect();
        $query = "SELECT * from wishlists where user_id= $user_id";
        $result = $db->get_list($query)->fetchAll();
       return $result;

    }
    
    function remove($pro_id, $user_id)
    {
        $db = new connect();
        $query = "DELETE FROM wishlists WHERE pro_id=$pro_id and user_id = $user_id";
        $result = $db->exec($query);
        return $result;
    }
    function sum_total()
    {
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['total'];
        }
        return number_format($subtotal, 2);
    }
} ?>