<?php
class accounts
{
    // ham khoi tao
    function __construct()
    {
    }
    // phương thức insert vào database 
    function InsertAdmin($first_name, $last_name, $username, $password, $phone, $email, $passwordAgain, $date_create)
    {
        if ($password == $passwordAgain) {
            $pass = md5($password);

            $db = new connect();
            $query = "INSERT INTO admins (id,image,First_name,Last_name,phone,email,username,password,roleId,date_create) VALUES (null,'avatar7.png','$first_name', '$last_name', $phone,'$email','$username', '$pass',1,'$date_create')";
            $db->exec($query);
        }
    }
    //phương thức kiểm tra tên người dùng
    function checkUser($username)
    {
        $db = new connect();
        $query = "SELECT * from admins where username= '$username'";
        $result = $db->get_Instance($query);
        return $result;
    }
    function loginAdmin($us, $pass)
    {
        $db = new connect();
        $select = "select * from admins where username = '$us' and password = '$pass'";
        $result = $db->get_Instance($select);
        return $result;
    }

    function checkRole($username)
    {
        $db = new connect();
        $select = "select * from admins where username='$username' and roleId =1";
        $result = $db->get_Instance($select);
        return $result;
    }
    //phương thức kiểm tra email
    function getEmail($email)
    {
        $db = new connect();
        $select = "select * from admins where email='$email'";
        $result = $db->get_instance($select);
        return $result;
    }
    function updatePassword($email, $newPass)
    {
        $db = new connect();
        $query = "update admins set password ='$newPass' where email='$email'";
        $db->exec($query);
    }
    function checkPassword($email, $password)
    {
        $db = new connect();
        $select = "select * from admins where email='$email' and password = '$password'";
        $result = $db->get_instance($select);
        return $result;
    }
    function countAllAccounts()
    {
        $db = new connect();
        $select = "SELECT COUNT(*) FROM admins";
        $result = $db->get_instance($select);
        return $result[0];
    }
    function countAccounts($keyword)
    {
        $db = new connect();
        $select = "select count(*) from admins";
        if ($keyword != "") {
            $select = "select count(*) from admins where  username = '$keyword'";
        }
        $result = $db->get_instance($select);
        return $result[0];
    }
    function getAllAccountUser($user, $email)
    {
        // $id_order = (int) $keyword;
        $db = new connect();
        if ($user != "" && $email == "") {
            $select = "select * from users where username like '%$user%'  order by user_id asc";
        } else if ($user == "" && $email != "") {
            $select = "select * from users where email = '%$email%'  order by user_id asc";
        } else {
            $select = "select * from users id order by user_id asc";
        }
        $result = $db->get_list($select);
        return $result;
    }
    function getAccountById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM admins WHERE id = $id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }

    function updateAccount($id, $idUpdate, $fullName, $phone, $email, $username, $role, $created_at)
    {
        $db = new connect();
        $query = "update admins set id=$idUpdate, fullName='$fullName',  phone=$phone,  email='$email',  username='$username',  roleId=$role, date_create='$created_at' where id=$id      ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }
    function removeAccount($id)
    {
        $db = new connect();
        $query = "delete from users where user_id = $id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }

    function resetPasswordAccount($id)
    {
        $db = new connect();
        $password = md5("Haiduong2k3");
        $query = "update users set password = '$password' where user_id = $id ";
        // $query="UPDATE `products` SET `id`=$idUpdate,`name`='$name',`type_id`=$type_id,`price`=$price,`promotion`=$promotion,`pro_image`='$image',`quantity`=$quantity,`description`='$description',`created_at`='$created_at' WHERE `id` = $id";
        $db->exec($query);
    }
    function getAccountUserById($id)
    {

        //b1 ket noi data
        $db = new connect();
        // b2 truy van
        $select = "SELECT * FROM users WHERE user_id = $id";
        //ai thuc hien select
        $result = $db->get_instance($select);
        return $result; //kết quả được lấy về 12 sản phẩm
    }
    function updateStatusAccountUser($id)
    {
        $db = new connect();
        $select = $this->getAccountUserById($id);
        if ($select) {
            if ($select['status'] == 0) {
                $update = "update users set status = 1 where user_id= $id";
            } else {
                $update = "update users set status = 0 where user_id = $id";
            }
            $result = $db->exec($update);
            return $result;
        }
    }

    function getRoleUser()
    {
        $db = new connect();
        $select = "select *from roleusers";
        $result = $db->get_list($select);
        return $result;
    }

    function updateAccountUser($id, $fullName, $phone, $email, $username, $role, $dateCreate)
    {
        $db = new connect();
        $update = "UPDATE users SET fullName='$fullName',phone=$phone,email='$email',username='$username',`role_id`=$role,date_create='$dateCreate' WHERE user_id = $id";
        $result = $db->exec($update);
        return $result;
    }
    function updateProfile($userId, $fullName, $email, $phone)
    {
        $db = new connect();
        $update = "UPDATE `admins` SET fullName = '$fullName',email='$email',phone=$phone WHERE id = $userId";
        $db->exec($update);
    }
    function updateAvatar($adminId, $fileName)
    {
        $db = new connect();
        $update = "UPDATE `admins` SET image='$fileName' where id=$adminId";
        $db->exec($update);
    }
    function updateAvatarUser($adminId, $fileName)
    {
        $db = new connect();
        $update = "UPDATE `users` SET image='$fileName' where user_id=$adminId";
        $db->exec($update);
    }
    function getAllRole()
    {
        $db = new connect();
        $select = "select * from roleusers";
        $result =  $db->get_list($select);
        return $result;
 
    }
}
