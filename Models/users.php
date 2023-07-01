<?php
class users
{
   // ham khoi tao
   public function __construct()
   {
   }
   // phương thức insert vào database 
   function InsertUser($fullName, $username, $password, $phone, $email, $passwordAgain, $date_create)
   {
      if ($password == $passwordAgain) {
         $pass = md5($password);
         $date = date("Y/m/d", strtotime($date_create));

         $db = new connect();
         $query = "INSERT INTO users (user_id,image,fullName,phone,email,username,facebookId,password,role_id,status,date_create) VALUES (null,'avatar.jpg','$fullName', $phone,'$email','$username',0, '$pass',2,0,'$date')";
         $db->exec($query);
     
      }
   }
   function InsertUserByFb($image, $fullName, $facebookId, $date_create)
   {


      $db = new connect();
      $query = "INSERT INTO `users`(`user_id`, `image`, `fullName`, `phone`, `email`, `username`, `facebookId`, `password`, `role_id`, `status`, `date_create`) 
                                 VALUES (null,'$image','$fullName',0,'','','$facebookId','',2,0,'$date_create')";
      $db->exec($query);
   }
   //phương thức kiểm tra tên người dùng
   function checkUser($username)
   {
      $db = new connect();
      $query = "SELECT * from users where username= '$username'";
      $result = $db->get_Instance($query);
      return $result;
   }


   function loginUser($us, $email, $pass)
   {
      $db = new connect();
      if ($us != "") {
         $select = "select * from users where username = '$us' and password = '$pass'";
      } else {
         $select = "select * from users where email = '$email' and password = '$pass'";
      }
      $result = $db->get_Instance($select);
      return $result;
   }
   //phương thức kiểm tra email
   function getEmail($email)
   {
      $db = new connect();
      $select = "select * from users where email='$email '";
      $result = $db->get_instance($select);
      return $result;
   }
   function updatePassword($user_id, $email, $newPass)
   {
      $db = new connect();
      if ($user_id == null) {
         $query = "update users set password ='$newPass' where email='$email'";
      } else {
         $query = "update users set password ='$newPass' where user_id=$user_id";
      }

      $db->exec($query);
   }
   function checkPassword($user_id, $email, $password)
   {
      $db = new connect();
      if ($user_id == null) {
         $select = "select * from users where email='$email' and password = '$password'";
      } else {
         $select = "select * from users where user_id=$user_id and password = '$password'";
      }

      $result = $db->get_instance($select);
      return $result;
   }

   function getUserById($id)
   {
      $db = new connect();
      $select = "select * from users where user_id =$id";
      $result = $db->get_instance($select);
      return $result;
   }
   function getUserByFaceId($facebookId)
   {
      $db = new connect();
      $select = "select * from users where facebookId =$facebookId";
      $result = $db->get_instance($select);
      return $result;
   }
   function updateProfile($userId, $fullName)
   {
      $db = new connect();
      $update = "UPDATE users SET fullName='$fullName' WHERE user_id = $userId";
      $db->exec($update);
   }

   function updateAvatar($userId, $img)
   {
      $db = new connect();
      $update = "UPDATE `users` SET image='$img' where user_id=$userId";
      $db->exec($update);
   }
}
