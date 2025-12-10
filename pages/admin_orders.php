<?php
require_once __DIR__ . "/../config/database.php";
require_once __DIR__ . "/../admin/manage.php";
require_once __DIR__ . "/../admin/dashboard.php";
require_once __DIR__ . "/../includes/functions.php";


if (isset($_GET["back"]) && $_GET["back"] == 1) {
    redirectToPage("admin.php");
}

$manage = new manage();
$orders = $manage->get_all_orders();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Orders</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
</head>
<body>
    
    <form method="get" action="<?= $_SERVER["PHP_SELF"] ?>">
        <input type="hidden" name="back" value="1">
        <input type="submit" value="Go back to manage page">
    </form>
    <h3>Search order</h3>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <br>Search by order ID <input type="number" name="user_id">
        <button type="submit">Search Order</button>
        <br>
    </form>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <br>Search by user ID <input type="number" name="order_id">
        <button type="submit">Search Order</button>
        <br>
    </form>
    <form action="<?= $_SERVER["PHP_SELF"] ?>" method="post">
        <br>Search by order status<br>

        <input type="radio" id="status_pending" name="order_status" value="pending">
        <label for="status_pending">Pending</label>

        <input type="radio" id="status_delivery" name="order_status" value="delivery">
        <label for="status_delivery">Delivery</label>

        <input type="radio" id="status_cancelled" name="order_status" value="cancelled">
        <label for="status_cancelled">Cancelled</label>

        <input type="radio" id="status_returned" name="order_status" value="returned">
        <label for="status_returned">Returned</label>

        <input type="radio" id="status_success" name="order_status" value="success">
        <label for="status_success">Success</label>
        <button type="reset">Reset</button>
        <br><button type="submit">Search Order</button>
        <br>
    </form>


    
    <h2>Show Orders Table</h2>
    <div>
        <table>
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Address</th>
                <th>Order Date</th>
                <th>Total Amount</th>
                <th>Status</th>
                <th>Payment</th>
                <th>Items</th>
            </tr>
            <?php
                if (!empty($orders)) {
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>{$order['order_id']}</td>";
                        echo "<td>" . htmlspecialchars($order['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($order['street_address']) . ", ". htmlspecialchars($order['city']). 
                        ", ". htmlspecialchars($order['province']) ."</td>";
                        echo "<td>{$order['order_date']}</td>";
                        echo "<td>P" . number_format($order['total_amount'], 2) . "</td>";
                        echo "<td>" . ucfirst($order['order_status']) . "</td>";
                        echo "<td>" . ucfirst($order['payment_status']) . "</td>";
                        echo "<td>{$order['total_items']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td>No orders found.</td></tr>";
                }
            
            ?>
        </table>
    </div>

</body>
</html>