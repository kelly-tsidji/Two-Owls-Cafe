<!-- show_orders.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show Orders</title>
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
    <h2>Orders Summary</h2>
    <table>
        <tr>
            <th>Order ID</th>
            <th>Order Date</th>
            <th>Customer Name</th>
            <th>Item Name</th>
            <th>Quantity</th>
            <th>Special Instructions</th>
        </tr>
        <?php
            // Connect to MySQL database
            $servername = 'localhost';
            $username = 'ueyyanqixaqoa';
            $password = 's1x)1j^2#$1$';
            $dbname = 'dbpzwvypeu6b2z';

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Query to select orders and corresponding order items
            $sql = "SELECT o.id AS order_id, o.order_date, CONCAT(o.first_name, ' ', o.last_name) AS customer_name, o.instructions AS special_instructions, oi.item_name, oi.quantity
                    FROM orders o
                    JOIN order_items oi ON o.id = oi.order_id
                    ORDER BY o.id";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["order_id"] . "</td>";
                    echo "<td>" . $row["order_date"] . "</td>";
                    echo "<td>" . $row["customer_name"] . "</td>";
                    echo "<td>" . $row["item_name"] . "</td>";
                    echo "<td>" . $row["quantity"] . "</td>";
                    echo "<td>" . $row["special_instructions"] . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No orders found.</td></tr>";
            }
            $conn->close();
        ?>
    </table>
</body>
</html>
