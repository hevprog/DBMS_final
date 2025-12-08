<?php 
    session_start();
    require_once __DIR__ . "/../config/database.php";
    require_once __DIR__ . "/../Classes/CartClass.php";
    require_once __DIR__ . "/../includes/functions.php";

    if(isset($_POST['checkout']))
    {
        if (!headers_sent()) 
        {
            redirectToPage('checkout.php');
        } 
    }

    $cart = new Cart();
    $cartItems = $cart->getCartItems($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping cart</title>
</head>
<body>
    <div style="text-align: center;">
        <h1> THIS IS YOUR SHOPPING CART </h1>

        <div>
            <table border="5" cellpadding="20">
                <tr>
                    <th>Product name</th>
                    <th>price</th>
                    <th>stock</th>
                    <th>RAM</th>
                    <th>ROM</th>
                </tr>

                <?php 
                        
                    if($cartItems && count($cartItems) > 0)
                    { 
                        foreach($cartItems as $item)
                        { ?>
                            <tr>
                                <td><?= $item['name'] ?></td>
                                <td><?= $item['price'] ?></td>
                                <td><?= $item['stock'] ?></td>
                                <td><?= $item['RAM'] ?></td>
                                <td><?= $item['ROM'] ?></td>
                            </tr>

                        <?php }  
                    }
                    else
                    {
                        echo "<tr><td colspan='7'>Cart is Empty :(</td></tr>";
                    }
            
                ?>
                 <tr>
                    <td>Total:</td>
                </tr>

            </table>
        </div>

    <div>
        <form action="cart.php" method="post">
            <button type="submit" name="checkout">Checkout</button>
        </form>
    </div>
</body>
</html>