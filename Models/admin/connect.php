<?php
class connect
{
    var $db = null;
    function __construct()
    {
        $dsn = 'mysql:host=localhost;dbname=fruitshop';
        $user = 'root';
        $pass = '';
        try {
            $this->db = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        } catch (\Throwable $th) {
            echo $th;
        }
    }

    function get_list($select)
    {
        $result = $this->db->query($select);
        return $result;
    }

    //phương thức thực thi trả về 1 object
    // thuoc thuc tra ve ob
    function get_instance($select)
    {
        $result = $this->db->query($select);
        $result = $result->fetch();
        return $result;
    }

    function exec($query)
    {
        $result = $this->db->exec($query);
        return $result;
    }
    function upLoadImage($nameFile,$dirName)
    {
       
        //tạo dường dẫn lưu hình
        $dir = $dirName;
        //lấy tên hình
        $file = $dir . basename($_FILES[$nameFile]['name']);
        echo $nameFile;
        echo $dirName;
        print_r($_FILES);
        //kiểm tra định dạng file
        $imageType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        //kiểm tra up load thành công không

        // if (isset($_POST['submit'])) {
        $check = getimagesize($_FILES[$nameFile]['tmp_name']);
        if ($check != false) {

            if (file_exists($file)) {

                return "image name already exists";
            }
            //kiểm tra size ảnh
            else if ($_FILES[$nameFile]['size'] > 500000) {

                return "images exceed 500kb";
            }
            //kiểm tra dduuoi mở rộng
            else
                    
                    if ($imageType !== "jpg" && $imageType !== "jpeg" && $imageType !== "png" && $imageType !== "gif") {

                return "file is not an image format";
            }
            //tiến hành đưa ảnh về thư mục
            else if (move_uploaded_file($_FILES[$nameFile]['tmp_name'], $file)) {
                return "success";
            } else {
                return "error";
            }
        } else {

            return "file image does not exist";
        }
        // }
    }


    function upLoadListImage($nameFile,$index ,$dirName)
    {

  
            //tạo dường dẫn lưu hình
            $dir = $dirName;
            //lấy tên hình
            $file = $dir . basename($_FILES[$nameFile]['name'][$index]);
            //kiểm tra định dạng file
            $imageType = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            //kiểm tra up load thành công không

            // if (isset($_POST['submit'])) {
            $check = getimagesize($_FILES[$nameFile]['tmp_name'][$index]);
            if ($check != false) {

                if (file_exists($file)) {

                    return "image name already exists";
                }
                //kiểm tra size ảnh
                else if ($_FILES[$nameFile]['size'][$index] > 500000) {

                    return "images exceed 500kb";
                }
                //kiểm tra dduuoi mở rộng
                else
                    
                    if ($imageType !== "jpg" && $imageType !== "jpeg" && $imageType !== "png" && $imageType !== "gif") {

                    return "file is not an image format";
                }
                //tiến hành đưa ảnh về thư mục
                else if (move_uploaded_file($_FILES[$nameFile]['tmp_name'][$index], $file)) {
                    return "success";
                } else {
                    return "error";
                }
            } else {

                return "file image does not exist";
            }
        
        
    }
}
