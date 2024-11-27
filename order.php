<?php

session_start();


// Include the cart.php file
include 'cart.php';

// Check if an image URL is passed via GET request
if (isset($_GET['image'])) {
    $imageUrl = 'img/' . $_GET['image'];
} else {
    $imageUrl = 'img/'; // Default image if none is provided
}

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "You need to log in first.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Page</title>
    <style>
        body {
            background-color: black;
            color: white; /* Optional: to make text readable on black background */
            margin-bottom: 150px; /* Ensure there's space for the footer */
        }
        .image-container {
            text-align: center;
            margin-top: 50px;
        }
        .image-item {
            position: relative;
            display: inline-block;
            margin: 10px;
        }
        .order-image {
            width: 250px; /* Set a fixed width */
            height: 300px; /* Set a fixed height */
            object-fit: cover; /* Ensure the image covers the area */
            border: 2px solid white;
            margin: 0 auto;
            cursor: pointer;
        }
        .remove-button {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
        .quantity-input {
            width: 50px;
            text-align: center;
        }
        .item-details {
            margin-top: 10px;
        }
        .total-price {
            margin-top: 20px;
            font-size: 24px;
        }
        .checkout-button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: green;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .checkout-button:hover {
            background-color: darkgreen;
        }
        .item-checkbox {
            position: absolute;
            top: 10px;
            left: 10px;
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: green;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            color: white;
            text-align: center;
            padding: 20px 0; /* Increase padding to position footer a little lower */
        }
        .image-title {
            margin-top: 10px;
            font-size: 16px;
            font-weight: bold;
        }
        .image-description {
            margin-top: 5px;
            font-size: 14px;
        }
        .contact-info {
            margin-top: 20px;
            text-align: center;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
            const imageContainer = document.querySelector(".image-container");
            const footer = document.querySelector("footer");
            let totalPriceElement;

			// Ensure each item has the 'selected' property
			cartItems.forEach(item => {
				if (typeof item.selected === 'undefined') {
				item.selected = true;  // Default to selected if 'selected' is not set
				}
			});

            function updateTotalPrice() {
                const totalPrice = cartItems.reduce((sum, item) => sum + (item.selected ? 500 * (item.quantity || 0) : 0), 0);
                totalPriceElement.textContent = `Total Price: ₱${totalPrice}`;
            }

            function renderCartItems() {
                imageContainer.innerHTML = ""; // Clear the container
                footer.innerHTML = ""; // Clear the footer

                cartItems.forEach((item, index) => {
                    const imageItem = document.createElement("div");
                    imageItem.classList.add("image-item");

                    const imgElement = document.createElement("img");
                    imgElement.src = item.imageUrl;
                    imgElement.alt = "Selected Image";
                    imgElement.classList.add("order-image");

                    const titleElement = document.createElement("div");
                    titleElement.classList.add("image-title");
                    titleElement.textContent = item.title;

                    const descriptionElement = document.createElement("div");
                    descriptionElement.classList.add("image-description");
                    descriptionElement.textContent = item.description;

                    const itemDetails = document.createElement("div");
                    itemDetails.classList.add("item-details");
                    itemDetails.innerHTML = `
                        <p>Price: ₱500</p>
                        <p>Quantity: <input type="number" class="quantity-input" value="${item.quantity}" min="1"></p>
                        <p>Total: ₱${500 * (item.quantity || 0)}</p>
                    `;

                    const quantityInput = itemDetails.querySelector(".quantity-input");
                    quantityInput.addEventListener("change", function() {
                        cartItems[index].quantity = parseInt(this.value) || 0;
                        localStorage.setItem("cartItems", JSON.stringify(cartItems));
                        itemDetails.querySelector("p:last-child").textContent = `Total: ₱${500 * cartItems[index].quantity}`;
                        updateTotalPrice();
                    });

                    const removeButton = document.createElement("button");
                    removeButton.classList.add("remove-button");
                    removeButton.textContent = "Remove";
                    removeButton.addEventListener("click", function() {
                        cartItems.splice(index, 1);
                        localStorage.setItem("cartItems", JSON.stringify(cartItems));
                        renderCartItems(); // Re-render the items
                        updateTotalPrice();
                    });

                    const checkbox = document.createElement("input");
                    checkbox.type = "checkbox";
                    checkbox.classList.add("item-checkbox");
                    checkbox.checked = item.selected; // Use the stored selected state
                    checkbox.addEventListener("change", function() {
                        cartItems[index].selected = this.checked;
                        localStorage.setItem("cartItems", JSON.stringify(cartItems));
                        updateTotalPrice();
                    });

                    imageItem.appendChild(checkbox);
                    imageItem.appendChild(imgElement);
                    imageItem.appendChild(titleElement);
                    imageItem.appendChild(descriptionElement);
                    imageItem.appendChild(itemDetails);
                    imageItem.appendChild(removeButton);
                    imageContainer.appendChild(imageItem);
                });

                totalPriceElement = document.createElement("div");
                totalPriceElement.classList.add("total-price");
                footer.appendChild(totalPriceElement);

                const checkoutButton = document.createElement("button");
                checkoutButton.classList.add("checkout-button");
                checkoutButton.textContent = "Check Out";
                checkoutButton.addEventListener("click", function() {
                     const selectedItems = cartItems.filter(item => item.selected);

                if (selectedItems.length === 0) {
                    alert("Please select at least one item to checkout.");
                    return;
                }

                // Replace `1` with the actual user ID from your session or login system
                const userId = <?php echo $_SESSION['user_id']; ?>;

                fetch("save_order.php", {
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
                    console.log(data); // Log the response to see what comes back
                    if (data.success) {
                        alert("Order saved successfully!");
                        // Optionally clear the cart and re-render the page
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
            footer.appendChild(checkoutButton);

            updateTotalPrice(); // Ensure the total price is updated initially
        }

            renderCartItems();
        });
    </script>
</head>
<body>
    <h1 style="text-align: center;">Shopping Cart</h1>
    <div class="image-container">
        <!-- Images will be inserted here by JavaScript -->
    </div>
    <footer>
        <!-- Total Price and Check Out button will be inserted here by JavaScript -->
    </footer>
</body>
</html>