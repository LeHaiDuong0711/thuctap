<?php
class bill
{
   public function __construct()
   {
   }
   // phương thức insert vào bảng hóa đơn
   public function insertOrder($order_id, $user_id, $fullName, $phone, $note)
   {
      $db = new connect();
      $date = new DateTime('now');
      $dateformat = $date->format('Y/m/d H:i:s');
      $insert = "INSERT INTO orders(order_id,user_id,fullName,phone,total,intoMoney,note,date_create,status,hide ) values($order_id,$user_id,'$fullName','$phone',0,0,'$note','$dateformat',0,0)";
      $result = $db->exec($insert);
      return $result;
 

   }
   public function insertOrderDetail($order_id, $pro_id, $prop_id, $pro_name, $price, $quantity, $total)
   {
      $db = new connect();
      $pro_id = intval($pro_id);
      $insert = "INSERT INTO orderdetails(id, order_id, pro_id, propertyId,pro_name, price, quantity, total) VALUES 
       (null,$order_id,$pro_id,$prop_id,'$pro_name',$price,$quantity,$total)";
      $db->exec($insert);
   }
   public function updateTotal($order_id, $sum_total, $intoMoney)
   {
      $db = new connect();
      $select = "UPDATE orders set total = $sum_total, intoMoney=$intoMoney where $order_id = order_id";
      $db->exec($select);
   }
   public function getOrderId()
   {
      $db = new connect();
      $order_id_temp = $db->get_instance("select order_id from orders ORDER BY order_id DESC LIMIT 1");

      $order_id = 1;
      if (isset($order_id_temp[0])) {
         $order_id = (int)$order_id_temp[0] + 1;
      }

      return $order_id;
   }

   public function updateQuantityProducts($pro_id, $prodId, $quantity)
   {
      $db = new connect();
      if (!isset($prodId) || $prodId == 0) {
         $update = "UPDATE products set quantity = quantity-$quantity where id = $pro_id  and quantity>=$quantity";
      } else {
         $update = "UPDATE propertys set quantity = quantity-$quantity where id = $prodId  and quantity>=$quantity";
         $db->exec($update);
         $select = "select sum(quantity) from propertys where prod_id = $pro_id";
         $result = $db->get_instance($select);
         $update = "UPDATE products set quantity = $result[0] where id = $pro_id ";
      }
      $db->exec($update);
   }

   public function getPromotions($code)
   {

      //b1 ket noi data
      $db = new connect();
      // b2 truy van
      $select = "SELECT * FROM promotion WHERE id = '$code'";
      //ai thuc hien select
      $result = $db->get_instance($select);
      return $result;
   }
   function getStatusOrderById($orderId)
   {
      $db = new connect();

      $select = "SELECT status FROM orders WHERE order_id = $orderId";

      $result = $db->get_instance($select);
      return $result['status'];
   }
   function getOrderById($orderId)
   {
      $db = new connect();

      $select = "SELECT * FROM orders WHERE order_id = $orderId";

      $result = $db->get_instance($select);
      return $result;
   }
   function getOrderIdLast()
   {
      $db = new connect();

      $select = "SELECT order_id FROM orders order by order_id DESC limit 1";

      $result = $db->get_instance($select);
      return $result['order_id'];
   }
   function getOrderDetailByOrderId($orderId)
   {
      $db = new connect();

      $select = "SELECT * FROM orderdetails WHERE order_id =$orderId";

      $result = $db->get_list($select);
      return $result;
   }
   function updateStatusOrder($orderId, $status, $nameStatus)
   {
      $db = new connect();
      $date = new DateTime('now');
      $dateformat = $date->format('Y/m/d H:i:s');
      if ($nameStatus == 'cancel') {
         $update = "UPDATE orders SET status = $status, cancellation_date = '$dateformat'  WHERE order_id = $orderId";
         $result = $db->exec($update);
         return $result;
      } else 
            if ($nameStatus == 'received') {
         $update = "UPDATE orders SET status = $status, received_date = '$dateformat'  WHERE order_id = $orderId";
         $result = $db->exec($update);
         return $result;
      } else
            if ($nameStatus == 'reset') {
         $getStatus = $this->getStatusOrderById($orderId);
     
         if ($getStatus == 3) {
            $update = "UPDATE orders SET status = $status, reset_date = '$dateformat'  WHERE order_id = $orderId";
            $result = $db->exec($update);
            return $result;
         } else 
            if ($getStatus == 2) {
              
            $order = $this->getOrderById($orderId);

            $newOrderId = $this->getOrderIdLast();
            $insertOrder = $this->insertOrder($newOrderId+1, $order['user_id'], $order['fullName'], $order['phone'], $order['note']);

            if ($insertOrder) {
               $orderDetail = $this->getOrderDetailByOrderId($orderId)->fetchAll();
         
               foreach ($orderDetail as $key => $value) {
                 
                  $insertOrderDetail = $this->insertOrderDetail($newOrderId+1, $value['pro_id'], $value['propertyId'], $value['pro_name'], $value['price'], $value['quantity'], $value['total']);
                  if (!$insertOrderDetail) {
                    $this->updateQuantityProducts($value['pro_id'], $value['propertyId'], $value['quantity']);
                     
                   
         
                  }
               }
               $updateOrder = $this->updateTotal($newOrderId+1,$order['total'],$order['intoMoney']);
               if(!$updateOrder){
                return $insertOrder;  
               }
               
            }
         }
      }
   }
}
