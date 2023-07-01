<?php 
class category{
    function __construct()
    {
        
    }
    function getCategoryByParent()
    {
        $db = new connect();
        
            $select = "select*from categorymenu where status = 0";
       
        $result = $db->get_list($select);
        return $result;
    }

   
    function getAllType()
    {
        $db = new connect();
        $select = "select * from protypes";
        
        $result = $db->get_list($select);
        return $result;
    }
}
?>