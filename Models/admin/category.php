<?php
class category
{
    function __construct()
    {
    }

    function insertCategory($parentId, $name, $title, $dateCreate) {
         $db = new connect();
      
            $insert= "INSERT INTO `categorymenu`(`id`, `parent_id`, `title`, `name`, `status`, `dateCreate`) VALUES (null,$parentId,'$title','$name',1,'$dateCreate')";
        
        $result = $db->exec($insert);
        return $result;
    }
    function getAllCategoryByKeyword($keyword)
    {
        $db = new connect();
        if ($keyword == "") {
            $select = "select*from categorymenu";
        } else {
            $select = "select*from categorymenu where name like '%$keyword%'";
        }
        $result = $db->get_list($select);
        return $result;
    }
    function getAllCategory()
    {
        $db = new connect();
        
            $select = "select*from categorymenu";
       
        $result = $db->get_list($select);
        return $result;
    }
    function getCategoryById($id)
    {
        $db = new connect();

        $select = "select*from categorymenu where id=$id";

        $result = $db->get_instance($select);
        return $result;
    }


    function updateStatusCategory($id)
    {
        $db = new connect();
        $select = $this->getCategoryById($id);
        if ($select) {
            if ($select['status'] == 0) {
                $update = "update categorymenu set status = 1 where id=$id";
            } else {
                $update = "update categorymenu set status = 0 where id = $id";
            }
            $result = $db->exec($update);
            return $result;
        }
    }

   
    function updateCategory($id,$parentId , $name, $title, $dateCreate)
    {

        $db = new connect();

        $update = "update categorymenu set parent_id=$parentId,name = '$name',title = '$title',dateCreate ='$dateCreate' where id=$id";

        $result = $db->exec($update);
        return $result;
    }
    function removeCategory($id)
    {
        $db = new connect();
        $delete = "delete from categorymenu where id = $id ";
        $result =  $db->exec($delete);
        return $result;
    }
   
}
