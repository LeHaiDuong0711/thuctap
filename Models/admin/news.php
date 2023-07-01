<?php
class news{
    function insertNews($idMul,$title,$image,$description,$content,$dateCreate)
    {
        $db = new connect();
        $insert = "INSERT INTO `news`(`id`,idCategoryMultiple, `title`, `image`, `description`, `content`, `status`, `dateCreate`) 
        VALUES (null,$idMul,'$title','$image','$description','$content',1,'$dateCreate')";
        $db->exec($insert);
    }
    function getAllNews()
    {
       $db = new connect();
       $select = "select * from news";
       $result = $db->get_list($select);
       return $result;
    }
  
    function getNewsById($id)
    {
        
       $db = new connect();
       $select = "select * from news where id =$id";
       $result = $db->get_instance($select);
       return $result;
    }
    
    function updateStatus($id)
    {
        $db = new connect();
        $select = $this->getNewsById($id);
        if ($select) {
            if ($select['status'] == 0) {
                $update = "update news set status = 1 where id=$id";
            } else {
                $update = "update news set status = 0 where id = $id";
            }
            $result = $db->exec($update);
            return $result;
        }
    }

    function removeNews($id)
    {
        $db = new connect();
        $delete = "delete from news where id = $id ";
        $db->exec($delete);
    }
    function updateNews($id,$idMul,$title,$image, $description,$content, $dateCreate)
    {
        $db = new connect();
        $update = "UPDATE `news` SET `idCategoryMultiple`=$idMul,`title`='$title',`image`='$image',`description`='$description',`content`='$content',`dateCreate`='$dateCreate' WHERE id =$id";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($update);
    }
    
}
