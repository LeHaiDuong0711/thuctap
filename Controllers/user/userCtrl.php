<?php
$act = 'home';
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}


switch ($act) {
        // case 'header':
        //     $c = new category();
        //     $result = $c->getAllCategory()->fetchAll();
        //     echo "##-##", json_encode($result), "##-##";
        //     break;

    case 'home':
        include "./Views/home.php";
        break;
    case 'countCart':
        if ($_SESSION['cart']) {
            echo "##-##", count($_SESSION['cart']), "##-##";
        } else {
            echo "##-##", 0, "##-##";
        }
        break;
    case 'home_act':
        $pr = new products();
        $proNewType1 = $pr->get3NewProductsByTypeID(1,0)->fetchAll();
        $proNewType2 = $pr->get3NewProductsByTypeID(2,0)->fetchAll();
        $proNewType3 = $pr->get3NewProductsByTypeID(3,0)->fetchAll();
        $arrRatingProNew = array();
        $arrCountCmt = array();
        $cmt = new comments();
        foreach ($proNewType1 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['id']);
            $item->id = $value['id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProNew, $item);
        }
        foreach ($proNewType2 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['id']);
            $item->id = $value['id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProNew, $item);
        }
        foreach ($proNewType3 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['id']);
            $item->id = $value['id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProNew, $item);
        }

        $proSelling1 = $pr->getProductsTopSellingByType(1)->fetchAll();
        $proSelling2 = $pr->getProductsTopSellingByType(2)->fetchAll();
        $proSelling3 = $pr->getProductsTopSellingByType(3)->fetchAll();
        $arrRatingProSelling = array();
        foreach ($proSelling1 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['pro_id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['pro_id']);
            $item->id = $value['pro_id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProSelling, $item);
        }
        foreach ($proSelling2 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['pro_id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['pro_id']);
            $item->id = $value['pro_id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProSelling, $item);
        }
        foreach ($proSelling3 as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['pro_id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['pro_id']);
            $item->id = $value['pro_id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRatingProSelling, $item);
        }



        echo "##-##", json_encode(array("proNewType1" => $proNewType1, "proNewType2" => $proNewType2, "proNewType3" => $proNewType3, 'arrRatingProNew' => $arrRatingProNew, "proSelling1" => $proSelling1, "proSelling2" => $proSelling2, "proSelling3" => $proSelling3, 'arrRatingProSelling' => $arrRatingProSelling)), "##-##";

        break;
    case 'products':
        include "./Views/products.php";
        break;
    case 'products_act':
        $pr = new products();
        $p = new page();
        $type_id = 0;
        $keyword = "";
        if (isset($_GET["type_id"])) {
            $type_id = $_GET["type_id"];
        }

        if (isset($_GET["keyword"])) {
            $keyword = $_GET["keyword"];
        }



        $result = $pr->getAllProductsPage($type_id, $keyword)->fetchAll();

        // $comments = $cmt->getComments($product['id'])->fetchAll();








        echo "##-##", json_encode($result), "##-##";
        // include "./Views/products.php";
        break;
    case 'rating':
        $products = $_POST['products'];
        $cmt = new comments();
        $arrRating = array();
        foreach ($products as $key => $value) {
            $item = new stdClass();
            $countCmt = count($cmt->getComments($value['id'])->fetchAll());
            $sumStar = $cmt->sumStar($value['id']);
            $item->id = $value['id'];
            $item->countCmt = $countCmt;
            $item->sumStar = $sumStar;
            array_push($arrRating, $item);
        }

        echo "##-##", json_encode($arrRating), "##-##";
        break;
    case 'productDetail':

        include "./Views/productDetail.php";
        break;
    case 'productDetail_act':
        // $_SESSION['oldServer'] = $_SERVER['REQUEST_URI'];
        if (isset($_GET['id'])) :
            $id = $_GET['id'];

            $pr = new products();

            $product = $pr->getProductById($id);
            $supplier = $pr->getSupplier($_GET['id']);
            $productsWillLove = $pr->get3NewProductsByTypeID($product['type_id'],$id)->fetchAll();
            $cmt = new comments();
            $comments = $cmt->getComments($product['id'])->fetchAll();
            $arrRating = array();
            foreach ($productsWillLove as $key => $value) {
                $item = new stdClass();
                $countCmt = count($cmt->getComments($value['id'])->fetchAll());
                $sumStar = $cmt->sumStar($value['id']);
                $item->id = $value['id'];
                $item->countCmt = $countCmt;
                $item->sumStar = $sumStar;
                array_push($arrRating, $item);
            }


            echo '##-##', json_encode(array('product' => $product, 'supplier' => $supplier, 'productsWillLove' => $productsWillLove, 'comments' => $comments, 'arrRating' => $arrRating)), '##-##';


        endif;

        include "./Views/productDetail.php";
        break;

    case 'getUser':
        $id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $us = new users();
        $result = $us->getUserById($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'getUserById':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $us = new users();
        $result = $us->getUserById($id);
        echo "##-##", json_encode($result), "##-##";
        break;

    case 'list_cart':
        if (!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            echo "##-##", "null", "##-##";
        } else {

            $ct = new cart();
            $subTotal = $ct->sum_total();
            echo "##-##", json_encode(array('carts' => $_SESSION["cart"], 'subTotal' => $subTotal)), "##-##";
        }

        break;
    case 'cart':
        include "./Views/cart.php";

    case 'add_cart':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 1;
            $id_property = isset($_POST['property']) ? $_POST['property'] : 0;
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
            }


            $ct = new cart();
            $ct->add($id, $id_property, $quantity);

            if ($ct) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        }
        break;





    case 'delete':

        if (isset($_POST['key'])) {
            $key = $_POST['key'];
            $gh = new cart();
            $gh->delete($key);
            if ($gh) {

                $ct = new cart();
                $subTotal = $ct->sum_total();
                echo "##-##", json_encode(array('carts' => $_SESSION["cart"], 'subTotal' => $subTotal)), "##-##";
            }
        };
        break;

    case 'update':
        if (isset($_POST['newqty'])) {
            $newQty = $_POST['newqty'];
            foreach ($_SESSION['cart'] as $index => $quantity) {
                if ($_SESSION['cart'][$index]['quantity'] != $quantity && $_POST['id']  == $_SESSION['cart'][$index]['id']) {

                    $updateItem = new cart();
                    $updateItem->update($index, $newQty, $_SESSION['cart'][$index]['id']);
                    if ($_SESSION['user_id']) {
                        $updateItem->updateQuantityCart($_SESSION['user_id'], $quantity['id'], $quantity['propertyId'], $newQty);
                    }
                }
            }

            echo "##-##", json_encode($_SESSION['cart']), "##-##";
        }



        break;

    case 'login':

        include "./Views/login.php";
        break;
    case 'login_act':

        // check if form is submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // get input values
            $check = $_POST['username'];
            $email = "";
            $username = "";
            if (preg_match('/^\\S+@\\S+\\.\\S+$/', $check) == 1) {

                $email = $check;
                $username = "";
            } else {
                $email = "";
                $username = $check;
            }
            $password = $_POST['password'];
            $us = new users();
            $result = $us->loginUser($username, $email, md5($password));


            // // server-side authentication
            if ($result) {
                if ($result['status'] == 0) {
                    $_SESSION['user_id'] = $result['user_id'];
                    $_SESSION['fullName'] = $result['fullName'];

                    $_SESSION['username'] = $result['username'];
                    $cart = new cart();
                    $loadCart = $cart->loadCart($result['user_id']);
                    echo '##-##', 'success', '##-##';
                } else {
                    echo '##-##', 'account is locked', '##-##';
                }
            } else {
                echo '##-##', 'error', '##-##';
            }
        }


        break;
    case 'logout':
        unset($_SESSION['user_id']);
        unset($_SESSION['fullName']);

        unset($_SESSION['username']);
        unset($_SESSION['cart']);
        echo "##-##", "success", "##-##";

        break;

    case 'register':
        include "./Views/register.php";
        break;
    case 'register_act':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $fullName = $_POST['fullName'];

            $username = $_POST['username'];
            $password = $_POST['password'];
            $passwordAgain = $_POST['passwordAgain'];
            $phone = $_POST['phone'];
            $email = $_POST['email'];
            $us = new users();
            $exist = $us->checkUser($username);
            $checkEmail = $us->getEmail($email);
            if ($exist) {
                echo "##-##", "errUsername", "##-##";
            } else {
                if ($checkEmail) {
                    echo  "##-##", "errEmail", "##-##";
                } else {
                    $date = new DateTime("now");
                    $date_create = $date->format("Y/m/d");
                    $check = $us->InsertUser($fullName, $username, $password, $phone, $email, $passwordAgain, $date_create);
                    if (!isset($check)) {
                        echo "##-##", "success", "##-##";
                    } else {
                        echo "##-##", "error", "##-##";
                    }
                }
            }
        }



        break;
    case 'checkout':

        $us = new users();
        $user = $us->getUserById($_SESSION['user_id']);
        echo "##-##", json_encode(array('user' => $user, 'cart' => $_SESSION["cart"])), "##-##";

        break;
    case 'info':
        if (isset($_SESSION['user_id'])) {

            include './Views/infoUser.php';
        } else {
            echo "<script>alert('Bạn cần đăng nhập')</script>";
            include './Views/login.php';
        }
        break;
    case 'order':
        include "./Views/bill.php";
        break;
        //     case 'order_get':

        //         echo "##-##", json_encode($_SESSION['infoClient']), "##-##";



        //         break;
    case 'order_data':



        $fullName = "";

        $address = "";
        $phoneNumber = null;

        $createDate = "";
        $note = "";
        // $_SESSION['infoClient'] = [];
        $arrClient = array();


        if (($_SERVER['REQUEST_METHOD'] == 'POST')) {
            $bill = new bill();
            $orderId = $bill->getOrderId();

            $fullName = $_POST['fullName'];

            $address = $_POST['address'] . ", " . $_POST['commune'] . ", " . $_POST['district'] . ", " . $_POST['country'];
            $date = new DateTime('now');
            $dateformat = $date->format('Y/m/d');
            $createDate = $dateformat;
            $phoneNumber = $_POST['phone'];
            $note = $_POST['note'];
            $provisional = $_POST['prov'];
            $item = new stdClass();
            $item->id = $orderId;
            $item->fullName = $fullName;
            $item->address = $address;
            $item->dateCreate = $createDate;
            $item->phoneNumber = $phoneNumber;
            $item->note = $note;
            $item->provisional = $provisional;
            $_SESSION['infoClient'] = $item;


            // array_push($arrClient, $item);

            echo "##-##", json_encode(array('infoClient' => $_SESSION['infoClient'], 'carts' => $_SESSION['cart'])), "##-##";
        } else {
            echo "##-##", json_encode(array('infoClient' => $_SESSION['infoClient'], 'carts' => $_SESSION['cart'])), "##-##";
        }








        break;
    case 'order_action':
        $intoMoney = $_POST['intoMoney'];

        $bill = new bill();
        $sum_total = 0;

        $insertOrder = $bill->insertOrder($_SESSION['infoClient']->id, $_SESSION['user_id'], $_SESSION['infoClient']->fullName, $_SESSION['infoClient']->phoneNumber, $_SESSION['infoClient']->note);
        if($insertOrder){
            $order_id = $bill->getOrderIdLast();
        }
        if ($order_id) {
            $_SESSION['order_id'] = $order_id;

            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $cart) {
                    $idProp = !$cart['idProperty'] ? 0 : $cart['idProperty'];
                    $bill->insertOrderDetail($order_id, $cart['id'], $idProp, $cart['name'], $cart['unit_price'], $cart['quantity'], $cart['total']);
                    $sum_total += $cart['total'];
                    $bill->updateQuantityProducts($cart['id'], $idProp, $cart['quantity']);
                }
            }
            //insert những thông tin còn lại vào chi tiết hóa đơn

            //update tổng tiển qua bảng order
            $bill->updateTotal($order_id, $sum_total, $intoMoney);
            if ($bill) {
                $c = new cart();print_r($_SESSION['cart']);
                foreach ($_SESSION['cart'] as $key => $value) {
                    if ($_SESSION['cart'][$key]['version'] != "") {
                        $pr = new products();
                        $productProperty = $pr->getProductPropertyBySKU($_SESSION['cart'][$key]['id']);
                        $propertyId =   $productProperty['id'];
                        $prod_id = $productProperty['prod_id'];
                        
                    } else {
                        $propertyId = 0; $prod_id=0;
                    }
                    $c->deleteCart($prod_id, $propertyId, $_SESSION['user_id']);
                   
                }

                unset($_SESSION['cart']);
                unset($_SESSION['infoClient']);
                echo '##-##', 'success', '##-##';
            } else {
                echo '##-##', 'update total error', '##-##';
            }
        } else {
            echo '##-##', 'insert order error', '##-##';
        }





        break;
    case 'about':
        include "./Views/about.php";
        break;
    case 'contact':
        include "./Views/contact.php";
        break;
    case 'comment':
        if (!isset($_SESSION['user_id'])) {
            echo "##-##", json_encode("userErr"), "##-##";
        } else {
            if (isset($_POST['id'])) {
                $userId = $_SESSION['user_id'];
                $proId = $_POST['id'];
                $content = $_POST['content'];
                $star_rating = $_POST['starRating'];
                $cmt = new comments();
                $cmt->insertComments($proId, $userId, $content, $star_rating);
                echo '##-##', json_encode($cmt), "##-##";
            };
        }


        break;
    case 'commentReply':
        if (!isset($_SESSION['user_id'])) {
            echo "##-##", json_encode("userErr"), "##-##";
        } else {
            if (isset($_POST['id'])) {
                $userId = $_SESSION['user_id'];
                $parentId = $_POST['id'];
                $content = $_POST['comment'];

                $cmt = new comments();
                $cmt->insertCommentReply($userId, $parentId, $content);
                if ($cmt) {
                    $comment = $cmt->getCommentsReplyNewInsert();
                    if ($comment) {
                        echo '##-##', json_encode($comment), "##-##";
                    } else {
                        echo '##-##', "error", "##-##";
                    }
                } else {
                    echo '##-##', "insert error", "##-##";
                }
            };
        }


        break;

    case 'showCommentsReply':
        $parentId = isset($_GET['id']) ? $_GET['id'] : 0;
        $cmt = new comments();
        $comment = $cmt->getCommentsReply($parentId)->fetchAll();
        echo '##-##', json_encode($comment), "##-##";
        break;
    case 'forgotPassword':
        include "./Views/veriEmailForgotPassword.php";
        break;
    case 'forgot_action':
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $_SESSION['email'] = array();
            // kiểm tra email có tồn tại không
            $usr = new users();
            $checkemail = $usr->getEmail($email);
            if ($checkemail != false) {
                $_SESSION['email'] = $email;
                include "./Views/forgotPassword.php";
            } else {
                echo '<script> alert("Email không tồn tại");</script>';
                include "./Views/veriEmailForgotPassword.php";
            }
        }
        break;
    case 'resetPassword':
        // tạo ra code gửi qua mail đó
        $code = random_int(100, 1000);
        // tạo ra và lưu vào Session
        //tạo ra đối tượng

        $_SESSION['code'] = $code;
        $_SESSION['newPass'] = $_POST['password'];
        // tiến hành gửi mail
        $mail = new PHPMailer;
        $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
        $mail->Host = 'smtp.gmail.com';        //Sets the SMTP hosts of your Email hosting, this for Godaddy
        $mail->Port = 587;                                //Sets the default SMTP server port
        $mail->SMTPAuth = true;                            //Sets SMTP authentication. Utilizes the Username and Password variables
        $mail->Username = 'haiduong07112k3@gmail.com';                    //Sets SMTP username
        $mail->Password = 'nedfmpujtfeoergu'; //Phplytest20@php					//Sets SMTP password				//Sets SMTP password
        $mail->SMTPSecure = 'tls';                            //Sets connection prefix. Options are "", "ssl" or "tls"
        $mail->From = 'haiduong07112k3@gmail.com';            //Sets the From email address for the message
        $mail->FromName = 'HiddenFruitsShop';                //Sets the From name of the message
        $mail->AddAddress($_SESSION['email'], 'Reset password');        //Adds a "To" address
        //$mail->AddCC($_POST["email"], $_POST["name"]);	//Adds a "Cc" address
        $mail->WordWrap = 50;                            //Sets word wrapping on the body of the message to a given number of characters
        $mail->IsHTML(true);                            //Sets message type to HTML				
        $mail->Subject = "Forget Password";                //Sets the Subject of the message
        $mail->Body = 'Vui lòng nhập mã code sau ' . $code;                //An HTML or plain text message body
        if ($mail->Send())                                //Send an Email. Return true on success or false on error
        {
            echo '<script> alert("Gửi mail thành công");</script>';
        } else {
            echo '<script> alert("Lỗi gửi mail");</script>';
        }
        include "./Views/resetPassword.php";
        break;
    case 'updatePassword':
        if (isset($_POST['submit'])) {
            if (isset($_POST['otp'])) {
                $otp = $_POST['otp'];
            }



            if ($_SESSION['code'] == $otp) {
                // cập nhật
                $newPass = md5($_SESSION['newPass']);
                $email = $_SESSION['email'];
                $usr = new users();
                $usr->updatePassword(null, $email, $newPass);
                echo '<script> alert("Đổi Mật Khẩu Thành Công");</script>';
                echo '<meta http-equiv="refresh"  content="0; url=./index.php?act=login"/>';
            } else {
                echo '<script> alert("Mã code sai");</script>';
                include "./Views/resetPassword.php";
            }
        }
        break;
    case 'changePassword':
        include "./Views/veriChangePassword.php";
        break;
    case 'change_action':
        if (isset($_POST['submit'])) {
            $email = $_POST['email'];
            $_SESSION['email'] = array();
            // kiểm tra email có tồn tại không
            $usr = new users();
            $checkemail = $usr->getEmail($email);
            if ($checkemail != false) {
                $_SESSION['email'] = $email;
                include "./Views/changePassword.php";
            } else {
                echo '<script> alert("Email không tồn tại");</script>';
                include "./Views/veriChangePassword.php";
            }
        }
        break;
    case 'change':
        if (isset($_POST['submit'])) {
            if (isset($_POST['oldPassword'])) {
                $oldPass = $_POST['oldPassword'];
            }
            if (isset($_POST['newPassword'])) {
                $newPass = $_POST['newPassword'];
            }
            if (isset($_POST['newPasswordAgain'])) {
                $newPassAgain = $_POST['newPasswordAgain'];
            }
            $usr = new users();
            $checkOldPass = $usr->checkPassword(null, $_SESSION['email'], md5($oldPass));
            if ($checkOldPass) {
                if ($newPassAgain ==  $newPass) {
                    $usr->updatePassword(null, $_SESSION['email'], md5($newPass));
                    echo '<script> alert("Đổi Mật Khẩu Thành Công");</script>';
                    include "./Views/login.php";
                } else {
                    echo '<script> alert("Mật Khẩu Lặp Lại Không Chính Xác");</script>';
                    include "./Views/changePassword.php";
                }
            } else {
                echo '<script> alert("Mật Khẩu Củ Không Chính Xác");</script>';
                include "./Views/changePassword.php";
            }
        }
        break;

    case 'getWishlist':
        $proId = isset($_GET['id']) ? $_GET['id'] : 0;
        if (isset($_SESSION['user_id'])) {
            $wl = new wishlist();
            $check = $wl->getWishlist($_SESSION['user_id'], $proId);
            echo "##-##", json_encode($check), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'wishlist':
        include "./Views/wishList.php";
        break;
    case 'getListWishlist':

        if (isset($_SESSION['user_id'])) {
            $wl = new wishlist();
            $check = $wl->getWishlistByUser($_SESSION['user_id']);
            echo "##-##", json_encode($check), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'add_wishlist':

        if (isset($_SESSION['user_id'])) {
            $proId = isset($_POST['id']) ? $_POST['id'] : 0;
            $date = new DateTime("now");
            $date_create = $date->format("Y/m/d");
            $wl = new wishlist();
            $check = $wl->getWishlist($_SESSION['user_id'], $proId);
            if ($check) {
                echo "##-##", "exited", "##-##";
            } else {
                $result = $wl->addWishlist($_SESSION['user_id'], $proId, $date_create);

                if ($result) {
                    echo "##-##", "success", "##-##";
                } else {
                    echo "##-##", "error", "##-##";
                }
            }
        } else {
            echo "##-##", "user does not exited", "##-##";
        }
        break;

    case 'remove_wishlist':
        $proId = isset($_POST['id']) ? $_POST['id'] : 0;

        $wl = new wishlist();
        $wl->remove($proId, $_SESSION['user_id']);
        if ($wl) {
            echo "##-##", "success", "##-##";
        }

        break;
    case 'wishlist':

        include "./Views/wishlist.php";




        break;
    case 'getProductById':

        $prod_id = isset($_GET['prod_id']) ? $_GET['prod_id'] : 0;
        $pr = new products();
        $product = $pr->getProductById($prod_id);
        echo "##-##", json_encode($product), "##-##";




        break;
    case 'promotion':
        $code = "";

        if (isset($_POST['code'])) {
            $code = $_POST['code'];
        }

        $bill = new bill();
        $result = $bill->getPromotions($code);

        echo '##-##', json_encode($result), '##-##';

        break;
    case 'profile':
        include "./Views/profile.php";
        break;
    case 'profile_act':
        if (isset($_SESSION["user_id"])) {
            $us = new users();
            $result = $us->getUserById($_SESSION["user_id"]);
            echo "##-##", json_encode($result), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        };
        break;
    case 'myOrders':
        $status = null;
        if (isset($_GET['status'])) {
            $status = $_GET['status'];
        }
        if (isset($_SESSION["user_id"])) {
            $od = new orders();
            $pr = new products();
            $orders = $od->getOrders($_SESSION["user_id"], $status)->fetchAll();


            echo "##-##", json_encode($orders), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        };
        break;
    case 'myOrderDetails':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        $od = new orders();
        $result = $od->getOrderDetails($id)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'getProductByPropertyId':

        $id = isset($_GET['id']) ? $_GET['id'] : 0;


        $pr = new products();
        $result = $pr->getProductByPropertyId($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'productInOrder':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $pr = new products();

        $result = $pr->getProductById($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'productPropertyInOrder':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $pr = new products();

        $result = $pr->getProductPropertyById($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'change_password':
        if (isset($_POST['oldPassword'])) {
            $oldPass = $_POST['oldPassword'];
        }
        if (isset($_POST['password'])) {
            $newPass = $_POST['password'];
        }
        if (isset($_POST['newPasswordAgain'])) {
            $newPassAgain = $_POST['newPasswordAgain'];
        }
        $usr = new users();
        $checkOldPass = $usr->checkPassword($_SESSION['user_id'], null, md5($oldPass));
        if ($checkOldPass) {
            $usr->updatePassword($_SESSION['user_id'], null, md5($newPass));
            if ($usr) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        } else {
            echo "##-##", "old password wrong", "##-##";
        }

    case 'listMyOrder':
        include "./Views/listOrder.php";
        break;
    case 'editProfile':
        if (isset($_POST['fullName'])) {
            $fullName = $_POST['fullName'];
        }

        $us = new users();
        $us->updateProfile($_SESSION['user_id'], $fullName);
        if ($us) {
            echo "##-##", "success", "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'updateStatus':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $od = new orders();
            $od->updateStatus($id, $status);
            if (isset($od)) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        }


        break;
    case 'uploadAvatar':
        $cn = new connect();
        $result = $cn->upLoadImage('uploadAvatar');
        if ($result == "success" || $result == "image name already exists" || $result == "") {
            $us = new users();
            $us->updateAvatar($_SESSION['user_id'], $_FILES['uploadAvatar']['name']);
            if ($us) {
                $user = $us->getUserById($_SESSION['user_id']);
                echo "##-##", json_encode($user), "##-##";
            } else {
                echo  "##-##", "update error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }

        break;
    case 'news':
        include "./Views/news.php";
        break;
    case 'news_act':
        $n = new news();
        $result = $n->getAllNews()->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'newsDetail':
        include "./Views/newsDetail.php";
        break;
    case 'newsDetail_act':
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $n = new news();
        $result = $n->getNewsById($id);
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'loginFb':
        $date = new DateTime("now");
        $date_create = $date->format("Y/m/d");
        $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : "";

        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $image = isset($_POST['image']) ? $_POST['image'] : "";
        $facebookId = isset($_POST['id']) ? $_POST['id'] : 0;
        $facebookId = intval($facebookId);
        $us = new users();
        $user = $us->getUserByFaceId($facebookId);



        if (!$user) {
            $fileName = mt_rand(100000, 9999999999);
            $dir = "./Assets/img/" . $fileName . ".jpg";
            $avatar = $fileName . ".jpg";
            copy($image, $dir);

            $check = $us->InsertUserByFb($avatar, $fullName, $facebookId, $date_create);
            if (!$check) {
                $user = $us->getUserByFaceId($facebookId);
                if ($user != null) {
                    $_SESSION['user_id'] = $user['user_id'];
                    $_SESSION['fullName'] = $user['fullName'];

                    $_SESSION['username'] = $user['username'];
                    echo "##-##", "success", "##-##";
                } else {
                    echo "##-##", "error", "##-##";
                }
            } else {
                echo "##-##", "insert error", "##-##";
            }
        } else {
            $user = $us->getUserByFaceId($facebookId);
            if ($user != null) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['fullName'] = $user['fullName'];

                $_SESSION['username'] = $user['username'];
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        }





        // $appId = "1966806493681346";
        // $appSecret ="";
        // $redirectUri = urlencode("https://fruitshops.local/fruitShops/index.php?act=loginFb");
        // $code = isset($_GET['code'])?$_GET['code']:null;
        // $facebookAccessTokenUri="https://graph.facebook.com/v6.0/access_token?oauth?client_id=$appId&redirect_uri=$redirectUri&client_secret=$appSecret&code=$code";
        // $ch =curl_init();
        // curl_setopt($ch,CURLOPT_URL,$facebookAccessTokenUri);
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // $aResponse = json_decode($response);
        // $accessToken = $aResponse->access_token;
        // $ch =curl_init();
        // curl_setopt($ch,CURLOPT_URL,"https://graph.facebook.com/me?access_token=$accessToken");
        // curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // echo json_decode($response);
        break;
    case 'newsEveryday':
        include "./Views/newsEveryday.php";
        break;
    case 'newsEveryday_act':
        $n = new news();
        $result = $n->getNewsEveryday()->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'commodityNews':
        include "./Views/newsCommodity.php";
        break;
    case 'commodityNews_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $n = new news();
        $result = $n->getNewsByCategory($id)->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'marketNews':
        include "./Views/newsMarket.php";
        break;
    case 'marketNews_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $n = new news();
        $result = $n->getNewsByCategory($id)->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'typeProduct':
        $c = new category();
        $result = $c->getAllType()->fetchAll();

        echo '##-##', json_encode($result), '##-##';
        break;
    case 'filedProduct':
        $typeId = isset($_POST['typeId']) ? $_POST['typeId'] : 0;
        $data = isset($_POST['data']) ? $_POST['data'] : 0;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
        $pr = new products();
        $result = $pr->getProductByFiled($data, $typeId, $keyword)->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'filedProductByPrice':
        $typeId = isset($_POST['typeId']) ? $_POST['typeId'] : 0;
        $data = isset($_POST['data']) ? $_POST['data'] : 0;
        $keyword = isset($_POST['keyword']) ? $_POST['keyword'] : "";
        $pr = new products();
        $result = $pr->getProductByFiled($data, $typeId, $keyword)->fetchAll();
        echo '##-##', json_encode($result), '##-##';
        break;
    case 'likeComment':

        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $parent = isset($_POST['parent']) ? $_POST['parent'] : 0;
        $cmt = new comments();
        $result = $cmt->likeComment($id, $parent, $userId);
        if ($userId) {
            if ($result) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        } else {
            echo "##-##", "user doesn't exits", "##-##";
        }

        break;
    case 'getLike':
        $cmt = new comments();
        $result = $cmt->getAllLikeComment()->fetchAll();
        if ($result) {
            echo "##-##", json_encode($result), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }

        break;
    case 'unlikeComment':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $parent = isset($_POST['parent']) ? $_POST['parent'] : 0;
        $cmt = new comments();
        $result = $cmt->unlikeComment($id, $parent, $userId);
        if ($userId) {
            if ($result) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        } else {
            echo "##-##", "user doesn't exits", "##-##";
        }

        break;
    case 'getCategory':
        $c = new category();
        $result = $c->getCategoryByParent()->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
  
   
   
    case 'getProductProperty':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;


        $pr = new products();
        $result = $pr->getProductProperty($id)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'getPropertyById':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pr = new products();
        $result = $pr->getProductPropertyById($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'getProductOrder':
        $userId = isset($_POST['userId']) ? $_POST['userId'] : 0;
        $prodId = isset($_POST['prodId']) ? $_POST['prodId'] : 0;
        $pr = new products();
        $result = $pr->getProductOderByUser($userId, $prodId);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'cancelOrder':
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : 0;
        $bill = new bill();
        $result = $bill->updateStatusOrder($orderId, 3, 'cancel');
        if ($result) {
            echo "##-##", "success", "##-##";
        }

        break;
    case 'receivedOrder':
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : 0;
        $bill = new bill();
        $result = $bill->updateStatusOrder($orderId, 2, 'received');
        if ($result) {
            echo "##-##", "success", "##-##";
        }

        break;
    case 'replacedOrder':
        $orderId = isset($_POST['orderId']) ? $_POST['orderId'] : 0;
        $bill = new bill();
       
        $result = $bill->updateStatusOrder($orderId, 0, 'reset');
        if ($result) {
            echo "##-##", "success", "##-##";
        }

        break;
}
