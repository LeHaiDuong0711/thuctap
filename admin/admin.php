<?php session_start();

set_include_path(get_include_path() . PATH_SEPARATOR . '../Models/admin/');
spl_autoload_extensions('.php');
spl_autoload_register();
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Asia/Ho_Chi_minh');

?>
<!DOCTYPE html>
<?php if (strpos($_SERVER['PHP_SELF'], "admin") != false) :
    include "../Views/admin/head.php";

    $act = "";
    if (isset($_GET['act'])) {
        $act = $_GET['act'];
    }
?>


    <body>

        <div class="d-flex toggled" id="wrapper">

            <?php if (isset($_SESSION['adminId'])) :  include "../Views/admin/navLeft.php";
            endif ?>

            <div id="page-content-wrapper">
                <?php if (isset($_SESSION['adminId'])) : include "../Views/admin/navTop.php";
                endif  ?>

                <div class="containerBody">

                    <?php
                    if(!isset($_SESSION['adminId'])){
                    
                        include  "../Controllers/admin/auth.php" ;
                    } else {
                     include  "../Controllers/admin/adminCtrl.php";   
                    }
                     ?>
                </div>



            </div>




        </div>



    </body>
    <?php include "../Views/admin/footer.php"; ?>

<?php endif ?>
<script style="display:none">
  setTimeout(() => {
    $(".tox.tox-silver-sink.tox-tinymce-aux ").css("display", "none").remove();
  }, 900)
</script>