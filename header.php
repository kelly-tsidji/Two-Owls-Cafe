<!-- header.php -->

<?php
    // Define the name of the place
    $placeName = "The Two Owls Café";

    // Define the hours of operation
    $hoursOfOperation = "11am - 10pm";
?>

<header style="background-color: #0a4275; color: #ffffff; padding: 20px;">
    <h1 style="margin: 0;"><?php echo $placeName; ?></h1>
    <p style="margin: 0; font-size: 16px;">Hours of Operation: <?php echo $hoursOfOperation; ?></p>
    <a href="show_orders.php" class="admin-link">Admin</a>
</header>

<style>
    /* Style for the "Admin" link */
    .admin-link {
        color: #ffcc00;
        text-decoration: none;
        margin-top: 10px;
        display: inline-block;
    }

    /* Hover effect for the "Admin" link */
    .admin-link:hover {
        text-decoration: underline;
    }
</style>
