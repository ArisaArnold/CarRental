<!DOCTYPE html>
<html>

<head>
    <title>Car Rental Website</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <h1>Car Rental Website</h1>
    <table id="carTable">
        <thead>
            <tr>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>Color</th>
                <th>Availability</th>
                <th>Price</th>
                <th>Image</th>
                <th>Add to Cart</th>
            </tr>
        </thead>
        <tbody id="carTableBody"></tbody>
    </table>

    <script>
        $(document).ready(function () {
            // Load cars from JSON file
            $.getJSON("cars.json", function (data) {
                var cars = data.cars;
                var carTableBody = $("#carTableBody");

                // Populate the car table with data
                $.each(cars, function (index, car) {
                    var row = "<tr>";
                    row += "<td>" + car.make + "</td>";
                    row += "<td>" + car.model + "</td>";
                    row += "<td>" + car.year + "</td>";
                    row += "<td>" + car.color + "</td>";
                    row += "<td>" + (car.availability ? "Available" : "Unavailable") + "</td>";
                    row += "<td>" + car.price + "</td>";
                    row += "<td><img src='car_images/" + car.picture + "' alt='Car Image'></td>";
                    row += "<td><button class='add-to-cart' data-car='" + JSON.stringify(car) + "'>Add to Cart</button></td>";
                    row += "</tr>";
                    carTableBody.append(row);
                });

                // Add to Cart button click event
                // Add to Cart button click event
                $("#carTableBody").on("click", ".add-to-cart", function () {
                    var car = $(this).data("car");

                    if (!car.availability) {
                        // Display alert if the car is unavailable
                        alert("This car is currently unavailable. Please select another car.");
                        return;
                    }

                    $.ajax({
                        type: "POST",
                        url: "cart.php",
                        data: {
                            action: "add_to_cart",
                            car: JSON.stringify(car) // Store the car object as a JSON string
                        },
                        dataType: "json",
                        success: function (response) {
                            if (response.success) {
                                // Display success message
                                alert("Car added to cart successfully!");
                                // Redirect to the cart page
                                window.location.href = "cart.php";
                            } else {
                                // Display error message
                                alert("Failed to add car to cart. Please try again.");
                            }
                        },
                        error: function (xhr, status, error) {
                            // Display error message
                            alert("An error occurred while adding the car to the cart. Please try again.");
                        }
                    });
                });

            });
        });
    </script>
</body>

</html>