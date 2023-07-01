
<?php
class news
{

    function __construct()
    {
        
    }

    function getAllNews()
    {
        $db = new connect();
        $select = "select * from news where status = 0 order by id desc";
        $result = $db->get_list($select);
        return $result;
    }
    function getNewsEveryday()
    {   $date = date("Y/m/d");
       $db = new connect();
       $select = "select * from news where dateCreate = '$date' and status = 0 order by id desc";
       $result = $db->get_list($select);
       return $result;
    }
    function getNewsById($id)
    {
        $db = new connect();
        $select = "select * from news where id = $id";
        $result = $db->get_instance($select);
        return $result;
    }
    function getNewsByCategory($id)
    {
        
       $db = new connect();
       $select = "select * from news where idCategoryMultiple =$id and status = 0 order by id desc" ;
       $result = $db->get_list($select);
       return $result;
    }
} ?>