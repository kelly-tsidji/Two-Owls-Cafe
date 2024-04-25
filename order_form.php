<!-- order_form.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Form</title>
    <script>
        function calculatePickupTime() {
            var now = new Date();
            now.setMinutes(now.getMinutes() + 20);
            var pickupTime = now.getHours() + ":" + (now.getMinutes() < 10 ? '0' : '') + now.getMinutes();
            document.getElementById("pickup_time").value = pickupTime;
        }
        
        function validateForm() {
            var itemsSelected = false;
            var itemName = document.getElementsByName("quantity[]");
            for (var i = 0; i < itemName.length; i++) {
                if (itemName[i].value > 0) {
                    itemsSelected = true;
                    break;
                }
            }
            if (!itemsSelected) {
                alert("Please select at least one item.");
                return false;
            }

            var firstName = document.getElementById("first_name").value.trim();
            var lastName = document.getElementById("last_name").value.trim();
            if (firstName === "" || lastName === "") {
                alert("Please provide your full name.");
                return false;
            }

            calculatePickupTime();

            return true;
        }

    </script>
</head>
<body>
    <?php include 'header.php'; ?>

    <h2>Order Form</h2>
    <form action="process_order.php" method="get" onsubmit="return validateForm()">
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

            // Query to select menu items from the database
            $sql = "SELECT * FROM menu";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                // Output data of each row
                while($row = $result->fetch_assoc()) {
                    echo "<h3>" . $row["name"] . "</h3>";
                    echo "<p>Description: " . $row["description"] . "</p>";
                    echo "<p>Price: $" . $row["price"] . "</p>";
                    echo '<img src="img/' . $row["image_filename"] . '" alt="' . $row["name"] . '" width="150"><br>';
                    echo '<label for="quantity">Quantity:</label>';
                    echo '<select name="quantity[]" id="quantity">';
                    for ($i = 0; $i <= 10; $i++) {
                        echo '<option value="' . $i . '">' . $i . '</option>';
                    }
                    echo '</select><br><br>';
                }
            } else {
                echo "0 results";
            }
            $conn->close();
        ?>

        <!-- Additional fields -->
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>
        <label for="instructions">Special Instructions:</label><br>
        <textarea id="instructions" name="instructions" rows="4" cols="50"></textarea><br><br>
        <input type="hidden" id="pickup_time" name="pickup_time" value=""><br>

        <!-- Submit button -->
        <input type="submit" value="Submit Order">
    </form>
</body>
</html>
