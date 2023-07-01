<?php
class comments{
    function __construct()
    {
        
    }

    function removeComments($userId){
        $db = new connect();
        $query="delete from comments where user_id = $userId";
        $db->exec($query);
    }

    function removeCommentsByProduct($pro_id){
        $db = new connect();
        $query="delete from comments where pro_id = $pro_id";
        $db->exec($query);
    }
    
    function getComments($prodId){
        $db= new connect();
        $select = "select b.id, a.username, b.content,b.star_rating, b.date_cmt from users a inner join comments b on a.user_id=b.user_id where b.prod_id=$prodId order by date_cmt DESC ";
        $result=$db->get_list($select);
        return $result;
    }


}


?>