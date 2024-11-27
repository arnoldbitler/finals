<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to the login page or show a message
    echo "You need to log in first.";
    exit(); // Exit the script to prevent further execution
}

// If the user is logged in, proceed with the order processing

// If user is submitting an order, handle it here (POST request)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cart_items'])) {
    $cart_items = json_decode($_POST['cart_items'], true);
    
    // Database connection (example)
    $host = 'localhost';
    $db = 'myshop';
    $user = 'root';
    $pass = '';
    $mysqli = new mysqli($host, $user, $pass, $db);

    // Check for connection error
    if ($mysqli->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $mysqli->connect_error]);
        exit();
    }

    // Assuming you have an order processing function here
    $total_price = 0;
    foreach ($cart_items as $item) {
        $total_price += $item['price'] * $item['quantity'];
    }

    // Insert order into database
    $query = "INSERT INTO orders (user_id, total_price) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("id", $user_id, $total_price);
    
    if ($stmt->execute()) {
        $order_id = $stmt->insert_id;
        
        // Insert each item into the order_items table
        foreach ($cart_items as $item) {
            $product_id = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $item['price'];

            $item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)";
            $stmt = $mysqli->prepare($item_query);
            $stmt->bind_param("iiid", $order_id, $product_id, $quantity, $price);
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .cart-icon {
            cursor: pointer;
            font-size: 24px;
        }
        .message {
            display: none;
            color: green;
            font-size: 18px;
        }
    </style>
    <script>
        let cart = JSON.parse(localStorage.getItem('cartItems')) || []; // Retrieve cart from localStorage
        let total = 0;

        function addToCart(itemName, itemPrice, itemImage, productId) {
            let existingItem = cart.find(item => item.name === itemName);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({ name: itemName, price: itemPrice, image: itemImage, quantity: 1, product_id: productId });
            }
            total += itemPrice;
            localStorage.setItem('cartItems', JSON.stringify(cart)); // Store updated cart to localStorage
            updateCart();
        }

        function updateCart() {
            const cartDiv = document.getElementById('cart');
            cartDiv.innerHTML = '';
            cart.forEach(item => {
                const div = document.createElement('div');
                div.className = 'cart-item';
                div.innerHTML = `
                    <img src="${item.image}" alt="${item.name}">
                    <div class="cart-details">
                        <strong>${item.name}</strong><br>
                        ₱${item.price} x ${item.quantity} = ₱${item.price * item.quantity}
                    </div>
                `;
                cartDiv.appendChild(div);
            });
            document.getElementById('total').textContent = '₱' + total;
        }

			function checkout() {
				const user_id = <?php echo $_SESSION['user_id']; ?>; // PHP to insert user_id dynamically
				fetch('save_order.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						user_id: user_id,
						cart_items: cart
					})
				})
				.then(response => response.json())
				.then(data => {
					console.log(data);
					alert(data.message);
				})
				.catch(error => {
					console.error("Error:", error);
					alert("An error occurred.");
				});
			}
    </script>
</head>
</html>
