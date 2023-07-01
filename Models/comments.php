<?php
class comments
{
    function __construct()
    {
    }

    function insertComments($pro_id, $user_id, $content, $star_rating)
    {
        $db = new connect();
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $query = "Insert into comments(id,prod_id,user_id,content,star_rating,total_like,date_cmt) values(Null,$pro_id,$user_id,'$content',$star_rating,0,'$dateCreate')";
        $db->exec($query);
    }
    function sumStar($prod_id)
    {
        $db = new connect();
        $select = "select sum(a.star_rating) from comments a where prod_id = $prod_id";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getComments($prodId)
    {
        $db = new connect();
        $select = "select b.id,a.user_id,a.image, a.username, b.content,b.star_rating, b.date_cmt from users a inner join comments b on a.user_id=b.user_id where b.prod_id=$prodId order by date_cmt DESC ";
        $result = $db->get_list($select);
        return $result;
    }

    function insertCommentReply($userId, $parentId, $content)
    {
        $db = new connect();
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $query = "Insert into comments_reply(id,userId,comment_id,content,total_like,create_at) values(Null,$userId,$parentId,'$content',0,'$dateCreate')";
        $db->exec($query);
    }
    function getCommentsReply($idComment)
    {
        $db = new connect();
        $select = "select c.id,c.comment_id,c.userId,a.image, a.username, c.content, c.create_at from users a inner join comments b on a.user_id=b.user_id INNER JOIN comments_reply c ON c.comment_id = b.id where c.comment_id=$idComment";
        $result = $db->get_list($select);
        return $result;
    }

    function getCommentsReplyNewInsert()
    {
        $db = new connect();
        $select = "select c.id,c.comment_id,c.userId,a.image, a.username, c.content, c.create_at from users a inner join comments b on a.user_id=b.user_id INNER JOIN comments_reply c ON c.comment_id = b.id ORDER BY id DESC LIMIT 1";
        $result = $db->get_instance($select);
        return $result;
    }
    function updateTotalLike($id, $parent, $userId)
    {
        $db = new connect();
        if ($id == 0) {
            $select = "SELECT COUNT(user_id) FROM `like_comments` WHERE comment_id = $parent";
            $countCmtParent = $db->get_instance($select);
        } else {
            $select = "SELECT COUNT(user_id) FROM `like_comments` WHERE comment_id = $parent and comment_reply_id=$id";
            $countCmt = $db->get_instance($select);
        }

        if ($id == 0) {
            $update = "UPDATE `comments` SET `total_like`='$countCmtParent[0]' WHERE id = $parent";
        } else {
            $update = "UPDATE `comments_reply` SET `total_like`='$countCmt[0]' WHERE id = $id";
        }
        $result = $db->exec($update);
        return $result;
    }
    function likeComment($id, $parent, $userId)
    {
        $date = new DateTime();
        $create_at = $date->format("Y/m/d");
        $db = new connect();

        $insert = "INSERT INTO `like_comments`(`id`, `comment_id`, `comment_reply_id`, `user_id`, `create_at`) VALUES (null,$parent,$id,$userId,'$create_at')";
        $db->exec($insert);
        
        $result1 = $this->updateTotalLike($id, $parent, $userId);
        return $result1;
    }
    function unlikeComment($id, $parent, $userId)
    {
        $db = new connect();

        $insert = "DELETE FROM `like_comments` WHERE comment_id =$parent AND comment_reply_id =$id";
        $db->exec($insert);

        $result1 = $this->updateTotalLike($id, $parent, $userId);
        return $result1;
    }
    function getAllLikeComment()
    {
        $db = new connect();
        $select = "select * from like_comments";
        $result = $db->get_list($select);
        return $result;
    }
}
