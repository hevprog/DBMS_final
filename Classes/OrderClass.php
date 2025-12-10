<?php
class Order extends Database
{

    public function createOrder($userId, $addressId, $totalAmount, $paymentMethod)
    {
        try
        {               
            $sql = "INSERT INTO orders (user_id, address_id, total_amount, payment_method) VALUES (:userId, :addressId, :totalAmount, :paymentMethod);";
            $stmt = parent::connect()->prepare($sql);
            
            $stmt->bindValue(':userId', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':addressId', $addressId, PDO::PARAM_INT);
            $stmt->bindValue(':totalAmount', $totalAmount, PDO::PARAM_STR);
            $stmt->bindValue(':paymentMethod', $paymentMethod, PDO::PARAM_STR);

            $stmt->execute();
            
            return true;
        }
        catch(PDOException $e)
        {
            error_log("error: " . $e->getMessage());
            return [];
        }
    }

    public function addOrderItems($orderId, $cartItems)
    {
        return 0;
    }
}