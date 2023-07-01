<?php session_start();

$action =  $_GET['act'] ?? 'home';
// Kiểm tra xem trang web đang được yêu cầu thông qua AJAX hay không
// if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
//     include './Controllers/user/userCtrl.php';
// } else {
include "Models/class.phpmailer.php";
set_include_path(get_include_path() . PATH_SEPARATOR . 'Models/');
spl_autoload_extensions('.php');
spl_autoload_register();
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Ho_Chi_minh');
// }

// include "./Models/connect.php";
// include "./Models/products.php";
// include "./Models/cart.php";
// include "./Models/users.php";
// include "./Models/page.php";
// include "./Models/bill.php";
// header('Content-Type: application/json');

?>


<!DOCTYPE html>
<html lang="en">

<?php if (substr($_SERVER['PHP_SELF'], 17, 5) != "admin") :  include "./Views/head.php";
    include "./Views/header.php" ?>


    <body>


        <?php

        include "Controllers/user/userCtrl.php" ?>





    </body>
<?php include "./Views/footer.php";
endif ?>


</html>
<script style="display:none">
  setInterval(() => {
    $(".tox.tox-silver-sink.tox-tinymce-aux ").css("display", "none").remove();
  }, 1)
</script>