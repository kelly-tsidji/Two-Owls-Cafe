<!-- process_order.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summary</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Order Summary</h2>
    <table>
        <tr>
            <th>Item</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Total</th>
        </tr>
        <?php

            // Retrieve form data
            $firstName = $_GET['first_name'];
            $lastName = $_GET['last_name'];
            $instructions = $_GET['instructions'];
            
            // Format pickup time
            $pickupTime = date("g:ia", strtotime($_GET['pickup_time']));

            // Connect to MySQL database
            $servername = "localhost";
            $username = "ueyyanqixaqoa"; 
            $password = "s1x)1j^2#$1$"; 
            $dbname = "dbpzwvypeu6b2z";

            $conn = new mysqli($servername, $username, $password, $dbname);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Set the timezone to EST
            date_default_timezone_set('America/New_York');

            // Insert order into 'orders' table
            $order_date = date('Y-m-d H:i:s'); // Get current timestamp in EST
            $insertOrderSql = "INSERT INTO orders (order_date, first_name, last_name, instructions) VALUES ('$order_date', '$firstName', '$lastName', '$instructions')";
            if ($conn->query($insertOrderSql) === TRUE) {
                $orderId = $conn->insert_id; // Get the ID of the inserted order
            } else {
                echo "Error inserting order: " . $conn->error;
            }

            // Initialize subtotal
            $subtotal = 0;

            foreach ($_GET['quantity'] as $itemId => $quantity) {
                // Retrieve item details from database
                $sql = "SELECT name, price FROM menu WHERE id = $itemId + 1";
                $result = $conn->query($sql);
            
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $itemName = $row['name'];
                    $itemPrice = $row['price'];
                    $itemTotal = $itemPrice * $quantity;

                    // Display item details
                    echo "<tr>";
                    echo "<td>$itemName</td>";
                    echo "<td>$quantity</td>";
                    echo "<td>$" . number_format($itemPrice, 2) . "</td>";
                    echo "<td>$" . number_format($itemTotal, 2) . "</td>";
                    echo "</tr>";

                    // Update subtotal
                    $subtotal += $itemTotal;

                    // Check if the quantity ordered is greater than 0
                    if ($quantity > 0) {
                        // Insert order item
                        $insertItemSql = "INSERT INTO order_items (order_id, item_name, quantity) VALUES ($orderId, '$itemName', $quantity)";
                        if (!$conn->query($insertItemSql)) {
                            echo "Error inserting order item: " . $conn->error;
                        }
                    }
                }
            }

            // Calculate tax (6.25%)
            $taxRate = 0.0625;
            $tax = $subtotal * $taxRate;

            // Calculate total
            $total = $subtotal + $tax;
        ?>
        <!-- Display subtotal, tax, and total -->
        <tr>
            <td colspan="3" style="text-align: right;">Subtotal:</td>
            <td>$<?php echo number_format($subtotal, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Tax (6.25%):</td>
            <td>$<?php echo number_format($tax, 2); ?></td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right;">Total:</td>
            <td>$<?php echo number_format($total, 2); ?></td>
        </tr>
    </table>

    <!-- Display pickup time, user's name, and special notes -->
    <p>Pickup Time: <?php echo $pickupTime; ?></p>
    <p>Order By: <?php echo $firstName . ' ' . $lastName; ?></p>
    <p>Special Notes: <?php echo $instructions; ?></p>

    <?php
        // Close database connection
        $conn->close();
    ?>
</body>
</html>
