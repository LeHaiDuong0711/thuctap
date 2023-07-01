<?php
$act = "dashboard";
if (isset($_GET['act'])) {
    $act = $_GET['act'];
}

switch ($act) {

    case 'dashboard':
        include "../Views/admin/dashboard.php";
        break;
    case 'chart':
        include "../Views/admin/chart.php";
        break;
    case 'statistical':
        $today = getdate();
        $pro_name = array();
        $quantityBuy = array();
        $arrMonth = array();
        $arrTotalRevenue = array();

        if (isset($_POST['month'])) {
            $month = $_POST['month'];
        } else {
            $month = $today['mon'];
        }

        if (isset($_POST['year'])) {
            $year = $_POST['year'];
        } else {
            $year = $today['year'];
        }
        $pr = new products();
        $result = $pr->getStatistical($month, $year)->fetchAll();
        foreach ($result as $key => $value) {
            array_push($pro_name, $value['name']);
            array_push($quantityBuy, $value['quantity']);
        }

        $sl = new sales();
        $result = $sl->totalSalesByMonthYear($year)->fetchAll();
        foreach ($result as $key => $value) {
            array_push($arrMonth, $value['month']);
            array_push($arrTotalRevenue, $value['totalRevenue']);
        }


        echo "##-##", json_encode(array('arrProName' => $pro_name, 'arrQuantity' => $quantityBuy, 'arrMonth' => $arrMonth, 'arrTotalRevenue' => $arrTotalRevenue)), "##-##";
        break;

    case 'products':

        include "../Views/admin/listProducts.php";
        break;
    case 'listProducts':
        $pr = new products();
        $p = new page();
        $keyword = "";
        $type_id = 0;

        if (isset($_GET["keyword"])) {
            $keyword = $_GET["keyword"];
        }
        if (isset($_GET["type_id"])) {
            $type_id = $_GET["type_id"];
        }
        $result = $pr->getAllProductsPage($type_id, $keyword)->fetchAll();
        $cmt = new comments();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'statusProducts':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $pr = new products();
        $result = $pr->updateStatus($id);
        if ($result) {
            $product = $pr->getProductById($id);
            echo "##-##", json_encode($product['status']), "##-##";
        }

        break;
    case 'editProduct':

        include "../Views/admin/editProduct.php";
        break;
    case 'editProduct_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pr = new products();
        $product = $pr->getProductById($id);

        echo "##-##", json_encode($product), "##-##";
        break;

    case "editProduct_action":
        $pr = new products();
        $db = new connect();
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $price = isset($_POST['price']) ? $_POST['price'] : 0;
        $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : 0;
        $promotion = isset($_POST['promotion']) ? $_POST['promotion'] : 0;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        $description = isset($_POST['description']) ? $_POST['description'] : "";
        $supId = isset($_POST['supplier']) ? $_POST['supplier'] : 0;
        $classifyId = isset($_POST['classify_id']) ? $_POST['classify_id'] : 0;
        $dateAdd = isset($_POST['dateAdd']) ? $_POST['dateAdd'] : "";
        $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : "";
        $pr = new products();


        if (isset($_FILES['uploadImageProduct']['name'])) {
            $image = $_FILES['uploadImageProduct']['name'];
            if ($image != "") {
                $result = $db->upLoadImage("uploadImageProduct", "./../Assets/img/");
            } else {

                $image = isset($_POST['imageOld']) ? $_POST['imageOld'] : "";
                $result = "";
            }
        }



        if ($result == "success" || $result == "image name already exists" || $result == "") {
            $pr->updateProduct($id, $name, $type_id, $price, $promotion, $image, $quantity, $description, $supId, $dateAdd, $expiry, $dateCreate);
            if ($pr) {
                echo "##-##", "success", "##-##";
            } else {
                echo  "##-##", "update error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }



        break;

    case 'supplier':
        $pr = new products();
        $arrSupplier = $pr->getAllSupplier()->fetchAll();
        echo "##-##", json_encode($arrSupplier), "##-##";
        break;
    case 'type':
        $pr = new products();
        $type = $pr->getAllType()->fetchAll();
        echo "##-##", json_encode($type), "##-##";
        break;

    case 'add-product':
        include "../Views/admin/addProduct.php";
        break;
    case "addProduct_action":
        $pr = new products();
        $db = new connect();
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $name = isset($_POST['name']) ? $_POST['name'] : "";
        $price = isset($_POST['price']) ? $_POST['price'] : 0;
        $type_id = isset($_POST['type_id']) ? $_POST['type_id'] : 0;
        $promotion = isset($_POST['promotion']) ? $_POST['promotion'] : 0;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        $description = isset($_POST['description']) ? $_POST['description'] : "";
        $supId = isset($_POST['supplier']) ? $_POST['supplier'] : 0;
        $dateAdd = isset($_POST['dateAdd']) ? $_POST['dateAdd'] : "";
        $expiry = isset($_POST['expiry']) ? $_POST['expiry'] : "";
        $productProperty = isset($_POST['product']) ? $_POST['product'] : [];
        $arrProperty = isset($_POST['title']) ? $_POST['title'] : [];
        $imageProduct = isset($_FILES['uploadImageAddProduct']['name']) ? $_FILES['uploadImageAddProduct']['name'] : "";
        $imageProperty = isset($_FILES['uploadImageAddProductProperty']['name']) ? $_FILES['uploadImageAddProductProperty']['name'] : [];

        $pr = new products();





        $addColum = $pr->addColumProperty($arrProperty);
        if ($addColum == true) {

            if ($imageProduct != "") {
                $result = $db->upLoadImage("uploadImageAddProduct", "./../Assets/img/");
            }


            if ($result == "success" || $result == "image name already exists" || $result == "") {
                $product = $pr->insertProduct($name, $type_id, $price, $promotion, $imageProduct, $quantity, $description, $supId, $dateAdd, $expiry, $dateCreate);
                if ($product) {
                    $prod = $pr->getProductNew();
                    if ($prod) {
                        $check = 0;
                        foreach ($productProperty as $index => $value) {
                            $image = $imageProperty[$index];
                            if ($image != "") {
                                $resultImage = $db->upLoadListImage("uploadImageAddProductProperty", $index, "./../Assets/img/");
                            }


                            if ($resultImage == "success" || $resultImage == "image name already exists" || $resultImage == "") {
                                $imageProductProperty = $image;
                                $sku = "";
                                $sku .= $prod["id"] . "0" . $value['sku'];
                                $sku = intval($sku);
                                $props = array_intersect_key($value, array_flip($arrProperty));
                                $return = $pr->insertProductProperty($prod['id'], $sku, $imageProductProperty, $value['price'], $value['promotion'], $value['quantity'], $dateCreate, $props);
                                echo $return;
                                if ($return) {
                                    $check++;
                                }
                            } else {
                                echo "##-##", $resultImage, "##-##";
                            }
                        }
                        if ($check == count($productProperty)) {
                            echo "##-##", "success", "##-##";
                        } else {
                            echo "##-##", "insert product property error", "##-##";
                        }
                    }
                } else {
                    echo  "##-##", "insert product error", "##-##";
                }
            } else {
                echo "##-##", $result, "##-##";
            }
        }









        break;
    case "listProductProperty":
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pr = new products();
        $prodProp = $pr->getProductPropertyById($id)->fetchAll();
        echo "##-##", json_encode($prodProp), "##-##";
        break;

    case "remove-product":
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $pr = new products();
            $cmt = new comments();
            $comments = $cmt->getComments($id)->fetchAll();
            if ($comments) {
                $cmt->removeCommentsByProduct($id);
            }

            $result = $pr->removeProduct($id);
            if (!isset($result)) {
                echo '##-##', "success", "##-##";
            }
        }

        break;
    case 'listOrders':

        include "../Views/admin/listOrders.php";
        break;
    case 'listOrders_act':

        $sl = new sales();
        $p = new page();
        //lấy ra toàn bộ sản phẩm

        // $count=$result->rowCount();
        //giới hạn số lượng hiển thị
        $limit = 10;
        $keyword = "";
        if (isset($_GET['keyword'])) {

            $keyword = $_GET['keyword'];
        }
        // $count = $sl->countOrders($keyword);
        // $page = $p->findPage($count, $limit);
        // $start = $p->findStart($limit);
        // $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $result = $sl->getAllOrdersPage($keyword)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case "edit-order":
        include "../Views/admin/editOrder.php";
        break;
    case "editOrder_act":
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = 0;
        $userId = 0;
        $fullName = "";

        $phone = 0;
        $note = "";
        $status = 0;

        if (isset($_POST['id'])) {
            $id = $_POST['id'];

            if (isset($_POST['userId'])) {
                $userId  = $_POST['userId'];
            }

            if (isset($_POST['fullName'])) {
                $fullName = $_POST['fullName'];
            }
            if (isset($_POST['phone'])) {
                $phone = $_POST['phone'];
            }
            if (isset($_POST['note'])) {
                $note = $_POST['note'];
            }
            if (isset($_POST['status'])) {
                $status = $_POST['status'];
            }
            $sl = new sales();
            $sl->updateOrder($id, $userId, $fullName, $phone, $status, $note, $dateCreate);
            if (isset($sl)) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        }
        break;
    case 'updateStatus':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $sl = new sales();
            $sl->updateStatus($id, $status);
            if (isset($sl)) {
                echo "##-##", "success", "##-##";
            } else {
                echo "##-##", "error", "##-##";
            }
        }


        break;
    case 'updateHide':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $sl = new sales();
            $sl->updateHide($id);
            if ($sl) {

                $order = $sl->getOrderById($id);
                echo "##-##", json_encode($order['hide']), "##-##";
            }
        }


        break;
    case "listOrderDetails":
        include "../Views/admin/listOrderDetail.php";

        break;
    case "listOrderDetails_act":

        $sl = new sales();
        $p = new page();
        $order_id = 0;
        if (isset($_GET['id'])) {
            $order_id = $_GET['id'];
        }
        //lấy ra toàn bộ sản phẩm

        $count = $sl->countAllOrderDetail($order_id);
        //giới hạn số lượng hiển thị
        $limit = 10;
        $page = $p->findPage($count, $limit);
        $start = $p->findStart($limit);
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $result = $sl->getAllOrderDetailPage($order_id)->fetchAll();
        echo "##-##", json_encode($result), "##-##";




        break;
    case "editOrderDetail":
        include "../Views/admin/editOrderDetail.php";



        break;
    case "editOrderDetail_act":
        $id = 0;
        $idUpdate = 0;
        $quantity = 0;
        $total = 0;
        $orderId = 0;
        $proId = 0;

        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            if (isset($_POST['orderId'])) {
                $orderId = $_POST['orderId'];
            }
            if (isset($_POST['idUpdate'])) {
                $idUpdate = $_POST['idUpdate'];
            }
            if (isset($_POST['proId'])) {
                $proId = $_POST['proId'];
            }
            if (isset($_POST['quantity'])) {
                $quantity  = $_POST['quantity'];
            }
            if (isset($_POST['total'])) {
                $total  = $_POST['total'];
            }


            $sl = new sales();
            $result0 = $sl->getOrderById($idUpdate);
            if ($result0) {
                $subTotal = 0;
                $subTotal1 = 0;
                $orderDetail = $sl->updateOrderDetail($id, $idUpdate, $quantity, $total);

                if ($orderDetail) {
                    $result1 = $sl->getAllOrderDetail($orderId);
                    foreach ($result1 as $key => $value) {
                        $subTotal = $subTotal + $value['total'];
                    }
                    $result2 = $sl->getAllOrderDetail($idUpdate);
                    foreach ($result2 as $key => $value) {
                        $subTotal1 = $subTotal1 + $value['total'];
                    }
                    $update = $sl->updateTotalOrder($idUpdate, $subTotal1);
                    $update1 = $sl->updateTotalOrder($orderId, $subTotal);
                    $result3 = $sl->getAllOrders();
                    foreach ($result3 as $key => $value) {
                        if ($value['total'] == 0) {
                            $remove = $sl->removeOrder($value['order_id']);
                        }
                    }
                    // $result4 = $sl->getAllOrderDetail($idUpdate);
                    // for ($i = 0; $i < count(array($result4)); $i++) {
                    // }

                    echo "##-##", "success", "##-##";
                } else {
                    echo "##-##", "error", "##-##";
                }
            } else {
                echo "##-##", "order not exits", "##-##";
            }
        } else {
            echo "##-##", "order detail not exits", "##-##";
        }

        break;
    case 'getEditOrderDetail':

        $sl = new sales();
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        $result = $sl->getOrderDetailById($id);
        echo "##-##", json_encode($result), "##-##";

        break;


    case 'logout':
        unset($_SESSION['adminId']);
        unset($_SESSION['fullName']);

        unset($_SESSION['adminName']);
        echo '<meta http-equiv="refresh"  content="0; url=admin.php?act=login"/>';

        break;
    case 'news':
        include "../Views/admin/listNews.php";


        break;
    case 'listNews':

        $n = new news();
        $p = new page();
        $result = $n->getAllNews()->fetchAll();
        $cmt = new comments();
        echo "##-##", json_encode($result), "##-##";
        break;


    case 'statusNews':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $n = new news();
        $result = $n->updateStatus($id);
        if ($result) {
            $news = $n->getNewsById($id);
            echo "##-##", json_encode($news['status']), "##-##";
        }

        break;
    case 'addNews':
        include "../Views/admin/addNews.php";
        break;
    case 'addNews_act':
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $image = isset($_FILES['uploadImageNews']['name']) ? $_FILES['uploadImageNews']['name'] : "";
        $title = isset($_POST['title']) ? $_POST['title'] : "";
        $content = isset($_POST['content']) ? $_POST['content'] : "";
        $description = isset($_POST['description']) ? $_POST['description'] : "";
        $idMenuMul = isset($_POST['category']) ? $_POST['category'] : 0;
        $cn = new connect();
        $n = new news();
        $result = $cn->upLoadImage('uploadImageNews', './../Assets/img/');
        if ($result == "success" || $result == "image name already exists") {
            $n->insertNews($idMenuMul, $title, $image, $description, $content, $dateCreate);
            if ($n) {
                echo "##-##", "success", "##-##";
            } else {
                echo  "##-##", "insert error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }

        break;

    case 'removeNews':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $n = new news();
            $result = $n->removeNews($id);
            if (!isset($result)) {
                echo '##-##', "success", "##-##";
            }
        }

        break;
    case 'editNews':
        include "../Views/admin/editNews.php";
        break;
    case 'editNews_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $n = new news();
        $result = $n->getNewsById($id);
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'editNews_action':
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $idMul = isset($_POST['category']) ? $_POST['category'] : 0;

        $title = isset($_POST['title']) ? $_POST['title'] : "";
        $content = isset($_POST['content']) ? $_POST['content'] : "";
        $description = isset($_POST['description']) ? $_POST['description'] : "";
        $cn = new connect();

        if (isset($_FILES['newImageNews']['name'])) {
            $image = $_FILES['newImageNews']['name'];
            if ($image != "") {
                $result = $cn->upLoadImage("newImageNews", "./../Assets/img/");
            } else {

                $image = isset($_POST['imageOld']) ? $_POST['imageOld'] : "";
                $result = "";
            }
        }
        if ($result == "success" || $result == "image name already exists" || $result == "") {
            $n = new news();
            $n->updateNews($id, $idMul, $title, $image, $description, $content, $dateCreate);
            if ($n) {
                echo "##-##", "success", "##-##";
            } else {
                echo  "##-##", "update error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }








        break;
    case 'category':
        include "./../Views/admin/listCategory.php";
        break;
    case 'listCategory':

        $c = new category();
        $p = new page();

        if (isset($_GET["keyword"])) {
            $keyword = $_GET["keyword"];
        }
        $result = $c->getAllCategory($keyword)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'statusCategory':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }

        $c = new category();
        $result = $c->updateStatusCategory($id);
        if ($result) {
            $product = $c->getCategoryById($id);
            echo "##-##", json_encode($product['status']), "##-##";
        }

        break;



        // case 'categoryMultiple':
        //     include "./../Views/admin/listCategoryMultiple.php";
        //     break;
        // case 'categoryParent':
        //     $c = new category();
        //     $result = $c->getAllCategory()->fetchAll();
        //     echo "##-##", json_encode($result), "##-##";
        //     break;
        // case 'categoryChild':
        //     $c = new category();
        //     $result = $c->getCategoryMultipleByParent(5)->fetchAll();
        //     echo "##-##", json_encode($result), "##-##";
        //     break;
    case 'getCategory':
        $c = new category();
        $result = $c->getAllCategory()->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
        // case 'listCategoryChild':

        //     $c = new category();
        //     $p = new page();

        //     $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";

        //     $parent = isset($_GET["categoryParent"]) ? $_GET["categoryParent"] : 0;
        //     $result = $c->getAllCategoryChild($keyword, $parent)->fetchAll();
        //     echo "##-##", json_encode($result), "##-##";
        //     break;
        // case 'statusCategoryChild':
        //     $id = 0;
        //     if (isset($_POST['id'])) {
        //         $id = $_POST['id'];
        //     }

        //     $c = new category();
        //     $result = $c->updateStatusCategoryChild($id);
        //     if ($result) {
        //         $product = $c->getCategoryChildById($id);
        //         echo "##-##", json_encode($product['status']), "##-##";
        //     }

        //     break;
        // case 'editCategoryMultiple':
        //     include "./../Views/admin/editCategoryMultiple.php";

        //     break;
        // case 'editCategoryMultiple_act':
        //     $id = isset($_GET['id']) ? $_GET['id'] : 0;
        //     $c = new category();
        //     $result = $c->getCategoryChildById($id);
        //     $result1 = $c->getAllCategory()->fetchAll();
        //     echo "##-##", json_encode(array('categoryMultiple' => $result, 'categoryParent' => $result1)), "##-##";
        //     break;

        // case 'editCategoryMultiple_action':
        //     $date = new DateTime("now");
        //     $dateCreate = $date->format("Y/m/d");
        //     $id = isset($_POST['id']) ? $_POST['id'] : 0;
        //     $name = isset($_POST['nameCategoryMultiple']) ? $_POST['nameCategoryMultiple'] : "";
        //     $title = isset($_POST['titleCategoryMultiple']) ? $_POST['titleCategoryMultiple'] : "";
        //     $idParent = isset($_POST['editCategoryParent']) ? $_POST['editCategoryParent'] : 0;
        //     $c = new category();
        //     $result = $c->updateCategoryMultiple($id, $idParent, $name, $title, $dateCreate);
        //     if (isset($result)) {
        //         echo "##-##", "success", "##-##";
        //     } else {
        //         echo "##-##", "error", "##-##";
        //     }
        //     break;
        // case 'removeCategoryMultiple':
        //     if (isset($_POST['id'])) {
        //         $id = $_POST['id'];
        //         $c = new category();
        //         $result = $c->removeCategoryChild($id);
        //         if (!isset($result)) {
        //             echo '##-##', "success", "##-##";
        //         }
        //     }

        //     break;



    case 'editCategory':
        include "./../Views/admin/editCategory.php";

        break;
    case 'editCategory_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $c = new category();
        $result = $c->getCategoryById($id);
        echo "##-##", json_encode($result), "##-##";
        break;

    case 'editCategory_action':
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = isset($_POST['idCategory']) ? $_POST['idCategory'] : 0;
        $parentId = isset($_POST['parentId']) ? $_POST['parentId'] : 0;
        $name = isset($_POST['nameCategory']) ? $_POST['nameCategory'] : "";
        $title = isset($_POST['titleCategory']) ? $_POST['titleCategory'] : "";

        $c = new category();
        $result = $c->updateCategory($id, $parentId, $name, $title, $dateCreate);
        if ($result) {
            echo "##-##", "success", "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'removeCategory':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $c = new category();
            $result = $c->removeCategory($id);
            if ($result) {
                echo '##-##', "success", "##-##";
            }
        }

        break;
    case 'accountUser':
        include "./../Views/admin/listAccounts.php";
        break;
    case 'listAccountUser':

        $ac = new accounts();
        $p = new page();
        $keyword = isset($_GET["keyword"]) ? $_GET["keyword"] : "";
        if (preg_match('/^\\S+@\\S+\\.\\S+$/', $keyword) == 1) {

            $email = $keyword;
            $user = "";
        } else {
            $email = "";
            $user = $keyword;
        }

        $result = $ac->getAllAccountUser($user, $email)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'getRole':
        $acc = new accounts();
        $result = $acc->getAllRole()->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
    case 'statusAccountUser':
        $id = 0;
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
        }
        $ac = new accounts();
        $result = $ac->updateStatusAccountUser($id);
        if ($result) {
            $user = $ac->getAccountUserById($id);
            echo "##-##", json_encode($user), "##-##";
        }

        break;
    case 'editAccountUser':
        include "./../Views/admin/editAccount.php";

        break;
    case 'editAccountUser_act':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $ac = new accounts();
        $role = $ac->getRoleUser()->fetchAll();
        $result = $ac->getAccountUserById($id);
        echo "##-##", json_encode(array("account" => $result, "role" => $role)), "##-##";
        break;
    case 'editAccountUser_action':
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : "";

        $phone = isset($_POST['phone']) ? $_POST['phone'] : "";
        $role = isset($_POST['roleUser']) ? $_POST['roleUser'] : 0;
        $username = isset($_POST['adminName']) ? $_POST['adminName'] : "";
        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $ac = new accounts();
        $result = $ac->updateAccountUser($id, $fullName, $phone, $email, $username, $role, $dateCreate);

        if (isset($result)) {
            echo "##-##", "success", "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'removeAccountUser':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $ac = new accounts();
            $result = $ac->removeAccount($id);
            if (!isset($result)) {
                echo '##-##', "success", "##-##";
            }
        }

        break;

    case 'revenueStatistics':
        $sl = new sales();
        $result = $sl->countOrdersToday();
        $result1 = $sl->countAllOrders();
        $result2 = $sl->totalSalesToday();
        $result3 = $sl->totalRevenue();
        echo "##-##", json_encode(array("todaySales" => $result, "allOrders" => $result1, "totalSalesToday" => $result2, "totalRevenue" => $result3)), "##-##";


        break;
    case 'salesRevenue':
        $date = new DateTime("now");
        $year = $date->format("Y");
        $sl = new sales();
        $result = $sl->totalSalesByMonthYear($year)->fetchAll();
        $arrTotalSale = array();
        $arrMonth = array();
        $arrTotalRevenue = array();
        foreach ($result as $key => $value) {
            array_push($arrTotalSale, $value['totalSales']);
            array_push($arrMonth, $value['month']);
            array_push($arrTotalRevenue, $value['totalRevenue']);
        }
        echo "##-##", json_encode(array("arrMonth" => $arrMonth, "arrTotalSales" => $arrTotalSale, "arrTotalRevenue" => $arrTotalRevenue)), "##-##";
        break;
    case 'resetPasswordUser':
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $ac = new accounts();
            $result = $ac->resetPasswordAccount($id);
            if (!isset($result)) {
                echo '##-##', "success", "##-##";
            } else {
                echo '##-##', "error", "##-##";
            }
        }


        break;
    case 'infoAdminLogin':
        if (isset($_SESSION['adminId'])) {
            $ac = new accounts();
            $result = $ac->getAccountById($_SESSION['adminId']);
            echo "##-##", json_encode($result), "##-##";
        }
        break;
    case 'profile':
        include "./../Views/admin/profile.php";
        break;
    case 'profile_act':
        if (isset($_SESSION["adminId"])) {
            $ac = new accounts();
            $result = $ac->getAccountById($_SESSION["adminId"]);
            echo "##-##", json_encode($result), "##-##";
        } else {
            echo "##-##", "error", "##-##";
        };
        break;
    case 'editProfile':

        $fullName = isset($_POST['fullName']) ? $_POST['fullName'] : "";


        $email = isset($_POST['email']) ? $_POST['email'] : "";
        $phone = isset($_POST['phoneNumber']) ? $_POST['phoneNumber'] : "";
        $ac = new accounts();
        $ac->updateProfile($_SESSION['adminId'], $fullName, $email, $phone);
        if ($ac) {
            echo "##-##", "success", "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'uploadAvatar':
        $cn = new connect();
        $result = $cn->upLoadImage('uploadAvatar', "./../Assets/img/");
        if ($result == "success" || $result == "image name already exists" || $result == "") {
            $ac = new accounts();
            $ac->updateAvatar($_SESSION['adminId'], $_FILES['uploadAvatar']['name']);
            if ($ac) {
                $admin = $ac->getAccountById($_SESSION['adminId']);
                echo "##-##", json_encode($admin), "##-##";
            } else {
                echo  "##-##", "update error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }
        break;

    case 'uploadAvatarUser':
        $id = isset($_POST['id']) ? $_POST['id'] : 0;
        print_r($_FILES);
        $cn = new connect();
        $result = $cn->upLoadImage('uploadAvatar', "./../Assets/img/");
        if ($result == "success" || $result == "image name already exists" || $result == "") {
            $ac = new accounts();
            $ac->updateAvatarUser($id, $_FILES['uploadAvatar']['name']);
            if ($ac) {
                $admin = $ac->getAccountUserById($id);
                echo "##-##", json_encode($admin), "##-##";
            } else {
                echo  "##-##", "update error", "##-##";
            }
        } else {
            echo "##-##", $result, "##-##";
        }
        break;
    case 'add-category':
        include "./../Views/admin/addCategory.php";
        break;
    case 'addCategory_action':
        $date = new DateTime("now");
        $dateCreate = $date->format("Y/m/d");

        $parentId = isset($_POST['parentId']) ? $_POST['parentId'] : 0;
        $name = isset($_POST['nameCategory']) ? $_POST['nameCategory'] : "";
        $title = isset($_POST['titleCategory']) ? $_POST['titleCategory'] : "";

        $c = new category();
        $result = $c->insertCategory($parentId, $name, $title, $dateCreate);
        if ($result) {
            echo "##-##", "success", "##-##";
        } else {
            echo "##-##", "error", "##-##";
        }
        break;
    case 'editProductProperty':
        include "./../Views/admin/editProductProperty.php";

        break;
    case 'getProductPropertyBySKU':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $pr = new products();
        $productProperty = $pr->getProductPropertyBySKU($id);

        echo "##-##", json_encode($productProperty), "##-##";
        break;
    case 'updateProductProperty':
        $sku = isset($_POST['SKU']) ? $_POST['SKU'] : 0;
        $price = isset($_POST['price']) ? $_POST['price'] : 0;
        $promotion = isset($_POST['promotion']) ? $_POST['promotion'] : 0;
        $quantity = isset($_POST['quantity']) ? $_POST['quantity'] : 0;
        $imageOld = isset($_POST['imageOld']) ? $_POST['imageOld'] : 0;
        $image = isset($_FILES['uploadImage']['name']) ? $_FILES['uploadImage']['name'] : '';
        $pr = new products();
        $db = new connect();
        if ($image == '') {
            $image = $imageOld;
            $result = "";
        } else {
            $result = $db->upLoadImage("uploadImage", "./../Assets/img/");
        }
        if ($result == "success" || $result == "image name already exists" || $result == "") {

            $result = $pr->updateProductProperty($sku, $price, $promotion, $quantity, $image);
            if ($result) {
                echo "##-##", "success", "##-##";
            }
            echo "##-##", "error", "##-##";
            break;
        } else {
            echo "##-##", $result, "##-##";
        }

    case 'orderDetail':
        include "./../Views/admin/listOrderDetail.php";
     
        break;
    case 'orderDetail-act':
       
        $sl = new sales();
        $id = isset($_GET['id'])?$_GET['id']:0;
        $result = $sl->getAllOrderDetailPage($id)->fetchAll();
        echo "##-##", json_encode($result), "##-##";
        break;
}
