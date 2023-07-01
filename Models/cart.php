<?php class cart
{
    function __construct()
    {
    }

    function insertCart($userId, $proId, $propertyId, $quantity)
    {
        $db = new connect();
        $insert = "INSERT INTO carts(id, userId, proId, propertyId,quantity) VALUES 
        (null,$userId,$proId,$propertyId,$quantity)";
        $db->exec($insert);
    }
    function getCartByProId($proId, $propertyId)
    {
        $db = new connect();
        $select = "select * from carts where proId = $proId and propertyId= $propertyId";
        $result = $db->get_instance($select);
        return $result;
    }
    function getCartByUserId($userId)
    {
        $db = new connect();
        $select = "select * from carts where userId = $userId";
        $result = $db->get_list($select);
        return $result;
    }
    function getCartByUserIdAndProId($userId, $proId, $propertyId)
    {
        $db = new connect();
        $select = "select * from carts where userId = $userId and proId=$proId and propertyId= $propertyId";
        $result = $db->get_instance($select);
        return $result;
    }
    function deleteCart($proId, $propertyId, $userId)
    {
        $db = new connect();
        $delete = "DELETE FROM `carts` where proId = $proId and propertyId= $propertyId and userId = $userId";
        $db->exec($delete);
    }
    function updateQuantityCart($userId, $proId, $propertyId, $quantity)
    {
        $db = new connect();
        $update = "UPDATE carts SET quantity=$quantity WHERE userId = $userId and proId = $proId and propertyId =$propertyId";
        $db->exec($update);
    }

    function loadCart($userId)
    {
        if (isset($userId)) {
            if (isset($_SESSION['cart'])) {
                foreach ($_SESSION['cart'] as $key => $value) {
                    $item = $this->getCartByProId($value['id'], $value['idProperty']);
                    if (!$item) {
                        $this->insertCart($userId, $value['id'], $value['idProperty'], $value['quantity']);
                    } else {
                        $quantity = $value['quantity'] + $item['quantity'];
                        $this->updateQuantityCart($userId, $value['id'], $value['idProperty'], $quantity);
                    }
                }

                $cart = $this->getCartByUserId($userId)->fetchAll();
                if ($cart) {
                    unset($_SESSION['cart']);
                    foreach ($cart as $key => $value) {
                        $pr = new products();
                        $product = $pr->getProductById($value['proId']);
                        $id = $value['proId'];
                        $version = "";
                        $name = $product['name'];
                        $img = $product['pro_image'];
                        $quantity = $value['quantity'];
                        if ($product['promotion'] == 0) {
                            $unit_price = $product['price'];
                        } else {
                            $unit_price = $product['promotion'];
                        }
                        if ($value['propertyId']) {
                            $property =  $pr->getProductPropertyById($value['propertyId']);
                            $img = $property['image'];
                            $id = $property['SKU'];
                            $product = $pr->getProductById($property['prod_id']);
                            $name = $product['name'];
                            if ($property['promotion'] == 0) {
                                $unit_price = $property['price'];
                            } else {
                                $unit_price = $property['promotion'];
                            }
                            $filtered_array = array_filter($property, function ($key) {
                                return !is_numeric($key);
                            }, ARRAY_FILTER_USE_KEY);

                            $keys = array_keys($filtered_array);



                            $keys = array_slice($keys, 4);
                            $keys = array_slice($keys, 0, -5);


                            foreach ($keys as $item1) {
                                if ($property[$item1] != null &&  $property[$item1] != "") {
                                    $version .=  $property[$item1] . " / ";
                                }
                            }
                            $version = substr($version, 0, -2);
                        }


                        $total = $quantity * $unit_price;
                        $item = array(
                            'id' => $id,
                            'img' => $img,
                            'name' => $name,
                            'idProperty' => $value['propertyId'],
                            'version' => $version,
                            'quantity' => $quantity,
                            'unit_price' => $unit_price,
                            'total' => $total
                        );
                        $_SESSION['cart'][] = $item;
                    }
                }
            } else {
                $_SESSION['cart'] = array();
                $listCart = $this->getCartByUserId($userId)->fetchAll();
                foreach ($listCart as $key => $value) {
                    $pr = new products();


                    $product = $pr->getProductById($value['proId']);
                    $version = "";
                    $img = $product['pro_image'];
                    $name = $product['name'];
                    $id = $value['proId'];

                    if ($value['propertyId'] != 0) {

                       

                        $property =  $pr->getProductPropertyById($value['propertyId']);
                        $img = $property['image'];
                        $id = $property['SKU'];
                        $product = $pr->getProductById($property['prod_id']);
                        $name = $product['name'];
                        $filtered_array = array_filter($property, function ($key) {
                            return !is_numeric($key);
                        }, ARRAY_FILTER_USE_KEY);

                        $keys = array_keys($filtered_array);



                        $keys = array_slice($keys, 4);
                        $keys = array_slice($keys, 0, -5);


                        foreach ($keys as $item1) {
                            if ($property[$item1] != null &&  $property[$item1] != "") {
                                $version .=  $property[$item1] . " / ";
                            }
                        }
                        $version = substr($version, 0, -2);
                    }



                    $quantity = $value['quantity'];
                    if ($product['promotion'] == 0) {
                        $unit_price = $product['price'];
                    } else {
                        $unit_price = $product['promotion'];
                    }
                    $total = $quantity * $unit_price;
                    $item = array(
                        'id' => $id,
                        'img' => $img,
                        'name' => $name,
                        'idProperty' => $value['propertyId'],
                        'version' => $version,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'total' => $total
                    );
                    $_SESSION['cart'][] = $item;
                }
            }
        }
    }

    function add($id, $id_property, $quantity)
    {
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array();
        }

        $pr = new products();
        $product = $pr->getProductById($id);
        $img = $product['pro_image'];
        $idCart = $product['id'];
        $version = "";
        if ($product['promotion'] == 0) {
            $unit_price = $product['price'];
        } else {
            $unit_price = $product['promotion'];
        }

        $property = $pr->getProductPropertyById($id_property);
        if ($property) {
            $idCart =  $property['SKU'];
            if ($property['promotion'] == 0) {
                $unit_price = $property['price'];
            } else {
                $unit_price = $property['promotion'];
            }
            $img = $property['image'];
            $filtered_array = array_filter($property, function ($key) {
                return !is_numeric($key);
            }, ARRAY_FILTER_USE_KEY);

            $keys = array_keys($filtered_array);



            $keys = array_slice($keys, 4);
            $keys = array_slice($keys, 0, -5);


            foreach ($keys as $item1) {
                if ($property[$item1] != null &&  $property[$item1] != "") {
                    $version .=  $property[$item1] . " / ";
                }
            }
            $version = substr($version, 0, -2);
        }



        $total = $quantity * $unit_price;

        $item = array(
            'id' => $idCart,
            'img' => $img,
            'name' => $product['name'],
            'idProperty' => $id_property,
            'version' => $version,
            'quantity' => $quantity,
            'unit_price' => $unit_price,
            'total' => $total
        );

        $flag = 0;
        foreach ($_SESSION['cart'] as $key => $element) {
            if ($element['id'] == $item['id']) {
                $flag = 1;
                $element['quantity'] += $item['quantity'];
                $this->update($key, $element['quantity'], $id);
                break;
            }
        }
        if ($flag == 0) {
            $_SESSION['cart'][] = $item;
        }
        if ($_SESSION['user_id']) {
            $cart = $this->getCartByUserIdAndProId($_SESSION['user_id'], $id, $id_property);

            if (!$cart) {
                $this->insertCart($_SESSION['user_id'], $id, $id_property, $quantity);
            }
        }
    }

    function update($key, $quantity)
    {
        if ($quantity <= 0) {
            $this->delete($key);
        } else {
            $_SESSION['cart'][$key]['quantity'] = $quantity;
            $new_total = $_SESSION['cart'][$key]['quantity'] * $_SESSION['cart'][$key]['unit_price'];
            $_SESSION['cart'][$key]['total'] = $new_total;
        }
    }

    function delete($key)
    {
        if ($_SESSION['cart'][$key]['version'] != "") {
            $pr = new products();
            $productProperty = $pr->getProductPropertyBySKU($_SESSION['cart'][$key]['id']);
            $propertyId =   $productProperty['id'];
        } else {
            $propertyId = 0;
        }

        $this->deleteCart($_SESSION['cart'][$key]['id'], $propertyId, $_SESSION['user_id']);
        unset($_SESSION['cart'][$key]);
        $_SESSION['cart'] = array_values($_SESSION['cart']);
    }
    function sum_total()
    {
        $subtotal = 0;
        foreach ($_SESSION['cart'] as $item) {
            $subtotal += $item['total'];
        }
        return $subtotal;
    }

    public function countCart()
    {

        if (isset($_SESSION['cart'])) {
            $count = count($_SESSION['cart']);
        } else {
            $count = 0;
        }

        return $count;
    }
}
