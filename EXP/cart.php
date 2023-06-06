<!DOCTYPE html>
<html>

<head>
    <title>Shopping Cart</title>
    <style>
        /* Add your CSS styles for the cart page */
    </style>
</head>

<body>
    <?php
    session_start();

    // Function to clear the cart
    function clearCart()
    {
        unset($_SESSION['cart']);
    }

    // Clear Cart action
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'clear_cart') {
        clearCart();

        // Return a JSON response indicating success
        echo json_encode(['success' => true]);
        exit;
    }
    ?>

    <h1>Shopping Cart</h1>

    <table id="cartTable">
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Color</th>
                <th>Availability</th>
                <th>Price</th>
                <th>Image</th>
                <th>Rental Days</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody id="cartTableBody">
            <?php
            // Check if the cart is empty
            if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
                echo "<tr><td colspan='9'>Your cart is empty.</td></tr>";
            } else {
                foreach ($_SESSION['cart'] as $car) {
                    echo "<tr>";
                    echo "<td>{$car->make}</td>";
                    echo "<td>{$car->model}</td>";
                    echo "<td>{$car->year}</td>";
                    echo "<td>{$car->color}</td>";
                    echo "<td>{$car->availability}</td>";
                    echo "<td>{$car->price}</td>";
                    echo "<td><img src='car_images/{$car->picture}' alt='Car Image'></td>";
                    echo "<td>{$car->rentalDays}</td>";
                    echo "<td>{$car->totalCost}</td>";
                    echo "</tr>";
                }
            }
            ?>
        </tbody>
    </table>

    <button id="clearButton">Clear Cart</button>
    <button id="backButton">Back</button>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Clear button click event
            $("#clearButton").click(function () {
                // Clear the cart by sending an AJAX request to clear_cart action
                $.ajax({
                    type: "POST",
                    url: "cart.php",
                    data: {
                        action: "clear_cart"
                    },
                    dataType: "json",
                    success: function (response) {
                        if (response.success) {
                            // Clear the cart table body
                            $("#cartTableBody").empty();
                            // Display the empty cart message
                            $("#cartTableBody").append("<tr><td colspan='9'>Your cart is empty.</td></tr>");
                        } else {
                            // Display error message
                            alert("Failed to clear the cart. Please try again.");
                        }
                    },
                    error: function (xhr, status, error) {
                        // Display error message
                        alert("An error occurred while clearing the cart. Please try again.");
                    }
                });
            });

            // Back button click event
            $("#backButton").click(function () {
                // Redirect the user back to the landing page
                window.location.href = "landing.php";
            });
        });
    </script>
</body>

</html>