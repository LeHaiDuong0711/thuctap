<?php 
$act = "login";
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}

switch ($act) {
case 'login':
    include "../Views/admin/login.php";
    break;
case 'login_act':
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $ac = new accounts();
        $result = $ac->loginAdmin($username, md5($password));
        if ($result) {
            $_SESSION['adminId'] = $result['id'];
            $_SESSION['fullName'] = $result['fullName'];
       
            $_SESSION['adminName'] = $result['userName'];
            echo "##-##", "success", "##-##";
            // lưu thông tin vào session 
        } else {
            echo "##-##", "error", "##-##";
        }
    };

    break;
    default:
    echo "<script>alert('Vui lòng đăng nhập!')</script>";
    echo '<meta http-equiv="refresh"  content="0; url=admin.php?act=login"/>';
    break;
}
