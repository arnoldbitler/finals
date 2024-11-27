<?php
session_start(); // Start the session

// Enable error reporting to see all errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the user is logged in by checking if the session variable exists
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'You need to log in first.']);
    exit();
}

// Database connection (replace with your actual database connection)
$host = 'localhost';
$db = 'myshop';
$user = 'root';
$pass = '';
$mysqli = new mysqli($host, $user, $pass, $db);

// Check database connection
if ($mysqli->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $mysqli->connect_error]);
    exit();
}

// Check if the necessary data is received
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['user_id']) && isset($data['cart_items'])) {
    $user_id = $data['user_id'];
    $cart_items = $data['cart_items'];

    // Calculate total price
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Insert order into the orders table
    $query = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("id", $user_id, $total_price);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert each cart item into the order_items table
        foreach ($cart_items as $item) {
            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($item_query);
            $stmt->bind_param("iiid", $order_id, $item['product_id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        echo json_encode(['success' => true, 'message' => 'Order saved successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save order']);
    }

    $stmt->close();
    $mysqli->close();
    exit();
}

// Handle POST request for order placement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate the incoming data
    if (!isset($data['user_id']) || !isset($data['items']) || empty($data['items'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid data.']);
        exit();
    }

    $user_id = $data['user_id'];
    $total_price = $data['totalPrice'];
    $items = $data['items'];

    // Insert into orders table
    $query = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("id", $user_id, $total_price);

    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;

        // Insert order items
        foreach ($items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($item_query);
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);

            if (!$stmt->execute()) {
                error_log("Error inserting order item: " . $stmt->error);
                echo json_encode(['success' => false, 'message' => 'Failed to save order items']);
                exit();
            }
        }

        echo json_encode(['success' => true, 'message' => 'Order saved successfully']);
    } else {
        error_log("Error executing order insert: " . $stmt->error);
        echo json_encode(['success' => false, 'message' => 'Failed to save order']);
    }

    $stmt->close();
    $mysqli->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
</head>
<body>
    <button class="checkout-button">Checkout</button>

    <script>
        document.querySelector(".checkout-button").addEventListener("click", function() {
            const selectedItems = cartItems.filter(item => item.selected);

            if (selectedItems.length === 0) {
                alert("Please select at least one item to checkout.");
                return;
            }

            // Replace `1` with the actual user ID from your session or login system
            const userId = <?php echo $_SESSION['user_id']; ?>; // Example user ID (replace with actual user session ID)

            fetch("<?php echo $_SERVER['PHP_SELF']; ?>", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    user_id: userId, // Logged-in user ID (make sure this is a valid value)
                    items: selectedItems.map(item => ({
                        product_id: item.product_id, // Ensure `product_id` exists in the `selectedItems` data
                        quantity: item.quantity,
                        price: item.price, // Dynamic price from selected item
                    })),
                    totalPrice: selectedItems.reduce((sum, item) => sum + (item.price * (item.quantity || 0)), 0), // Use item.price dynamically
                }),
            })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                console.log(data); // Log the response to check what data you’re getting
                if (data.success) {
                    alert("Order saved successfully!");
                    cartItems = [];
                    localStorage.removeItem("cartItems");
                    renderCartItems();
                } else {
                    alert(data.message || "Failed to save the order.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Order saved successfully!");
            });
        });
    </script>
</body>
</html>
