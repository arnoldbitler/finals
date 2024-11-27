<?php

session_start(); // Start the session


// Database connection
$conn = new mysqli('localhost', 'root', '', 'myshop');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    <title>Shop</title>
    <link rel="stylesheet" href="css/shop.css">
        <script src="js/shop.js"></script>
    <script>
        function addToFavourite(image) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "favourite.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Product added to favourite!");
                }
            };
            xhr.send("product_id=" + image + "&user_id=<?php echo $user_id; ?>", true);  // Pass user_id in the request
        }

        function addToCart(image) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Product added to cart!");
                }
            };
            xhr.send("product_id=" + image + "&user_id=<?php echo $user_id; ?>", true);  // Pass user_id in the request
        }
    </script>
    <script src="shop.js" defer></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#footer">About</a></li>
            <li><a href="order.php">Orders</a></li>
        </ul>
    </nav>
    <h1>Top Selling Shirts</h1>
    <div class="container">
        <div class="image-container">
            <div class="banner">Top</div>
            <img src="img/ads.jpg" alt="Description of image">
            <div class="icons">
                <i class="fas fa-heart"></i>
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="image-container">
            <div class="banner">Top</div>
            <img src="img/hello.jpg" alt="Description of image">
			<div class="icons">
                <i class="fas fa-heart"></i>
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
        <div class="image-container">
            <div class="banner">Top</div>
            <img src="img/dsa.jpg" alt="Description of image">
            <div class="icons">
                <i class="fas fa-heart"></i>
                <i class="fas fa-shopping-cart"></i>
            </div>
        </div>
    </div>
    <br><br><br><br>
    <p id="description" style="text-align: center; color: white;">These top-selling designs showcase fan-favorites Gojo, Sukuna, and Killua, highlighting their iconic poses, bold colors, and unique character styles. </p>
    <p style="text-align: center; color: white;">Scroll for more</p>
    <br>
    <br><br><br><br><br><br><br><br><br><br>
    <div class="footer-images">
        <div class="image-container">
            <img src="img/Streetwear Design For Sale.jpg" alt="Image 1" data-product-id="1">
            <div class="discount-tag">-42% OFF</div>
            <div class="image-details">
                <h3>Manfinity UrbanChill Trust the Process White Knit</h3>
                <p>Price: <span style="text-decoration: line-through">₱850</span> <span>₱500</span></p>
                <p>white t-shirt fits slightly oversized with a relaxed, boxy fit.</p>
            </div>
            <div class="icons">
            <i class="fas fa-heart" onclick="addToFavourite(1)"></i>
			<i class="fas fa-shopping-cart" onclick="addToCart(1)"></i>

    <div id="message" class="message"></div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Streetwear Design Collection.jpg" alt="Image 2" data-product-id="2">
            <div class="discount-tag">-17% OFF</div>
            <div class="image-details">
                <h3>Manfinity Silence Men Cotton Graphic Tee</h3>
                <p>Price: <span style="text-decoration: line-through">₱600</span> <span>₱500</span></p>
                <p>Made from luxury cotton featuring soft and breathable fabric ensure quality and longevity.</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(2)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(2)"></i>
    <div id="message" class="message"></div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/har.jpg" alt="Image 3" data-product-id="3">
            <div class="discount-tag">-28% OFF</div>
            <div class="image-details">
                <h3>Manfinity RebelGame</h3>
                <p>Price: <span style="text-decoration: line-through">₱700</span> <span>₱500</span></p>
                <p>White Tee Collar Short Sleeve Fabric Graphic</p>
            </div>
            <div class="icons">
                <i class="fas fa-heart" onclick="addToFavourite(3)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(3)"></i>
    <div id="message" class="message">
    <a href="order.php"></a>
    </div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/bie.jpg" alt="Image 4" data-product-id="4">
            <div class="discount-tag">-33% OFF</div>
            <div class="image-details">
                <h3>Manfinity Trust the Process White Knit Mens T-Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱750</span> <span>₱500</span></p>
                <p>White Casual Short Sleeve Polyester Graphic,Letter Embellished Slight Stretch Summer Men Tops</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(4)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(4)"></i>
    <div id="message" class="message"></div>
            </div>
        </div>
    </div>
    <div class="footer-images">
        <div class="image-container">
            <img src="img/arono - Tshirt Design.jpg" alt="Image 1" data-product-id="5">
            <div class="discount-tag">-42% OFF</div>
            <div class="image-details">
                <h3>DAZY Men' Summer Solid Black T Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱850</span> <span>₱500</span></p>
                <p>Black Casual Collar Short Sleeve Fabric Cartoon,Letter Embellished Slight Stretch Summer Men Clothing</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(5)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(5)"></i>
                <div id="message" class="message"></div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Girl - Tshirt Design.jpg" alt="Image 2" data-product-id="6">
            <div class="discount-tag">-17% OFF</div>
            <div class="image-details">
                <h3>DAZY Men Solid Black T Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱600</span> <span>₱500</span></p>
                <p>Black Casual Collar Short Sleeve Fabric Cartoon,Letter Embellished Slight Stretch Summer Men Clothing</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(6)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(6)"></i>
    <div id="message" class="message"></div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Mind - Tshirt Design.jpg" alt="Image 3" data-product-id="7">
            <div class="discount-tag">-28% OFF</div>
            <div class="image-details">
                <h3>DAZY Men Solid Round Neck Tee</h3>
                <p>Price: <span style="text-decoration: line-through">₱700</span> <span>₱500</span></p>
                <p>Black Casual Collar Short Sleeve Fabric Cartoon,Letter Embellished Slight Stretch Summer Men Clothing</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(7)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(7)"></i>
    <div id="message" class="message"></div>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Sicko - Tshirt Design.jpg" alt="Image 4" data-product-id="8">
            <div class="discount-tag">-33% OFF</div>
            <div class="image-details">
                <h3>DAZY Men's Summer Round Neck Retro T-Shirt With Letter Print</h3>
                <p>Price: <span style="text-decoration: line-through">₱750</span> <span>₱500</span></p>
                <p>Black Casual Collar Short Sleeve Fabric Cartoon,Letter Embellished Slight Stretch Summer Men Clothing</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(8)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(8)"></i>
                <div id="message" class="message"></div>
            </div>
        </div>
    </div>
    <div class="footer-images">
        <div class="image-container">
            <img src="img/Heaven - Tshirt Design.jpg" alt="Image 1" data-product-id="9">
            <div class="discount-tag">-42% OFF</div>
            <div class="image-details">
                <h3>Streetwear Aesthetic Graphic Tee Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱850</span> <span>₱500</span></p>
                <p>Modern retro style streetwear t-shirt design</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(9)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(9)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/PCAG - Tshirt Design.jpg" alt="Image 2" data-product-id="10">
            <div class="discount-tag">-17% OFF</div>
            <div class="image-details">
                <h3>Aelfric Eden Graphic Print Vintage Oversized T-Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱600</span> <span>₱500</span></p>
                <p>Short description of the product.</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(10)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(10)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Triple One.jpg" alt="Image 3" data-product-id="11">
            <div class="discount-tag">-28% OFF</div>
            <div class="image-details">
                <h3>Vintage Spider Graphic 100% Cotton Short Sleeve T-Shirt Black-M</h3>
                <p>Price: <span style="text-decoration: line-through">₱700</span> <span>₱500</span></p>
                <p>White Street Collar Short Sleeve Fabric Halloween</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(11)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(11)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/Sick Life.jpg" alt="Image 4" data-product-id="12">
            <div class="discount-tag">-33% OFF</div>
            <div class="image-details">
                <h3>Urban Streetwear T-Shirt Design</h3>
                <p>Price: <span style="text-decoration: line-through">₱750</span> <span>₱500</span></p>
                <p>Short Sleeve T-Shirt, Casual Wear For Spring & Summer</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(12)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(12)"></i>
            </div>
        </div>
    </div>
    <div class="footer-images">
        <div class="image-container">
            <img src="img/Do unique graphic design for your streetwear brand by Willypom _ Fiverr.jpg" alt="Image 1" data-product-id="13">
            <div class="discount-tag">-47% OFF</div>
            <div class="image-details">
                <h3>The Cat Trip Tee</h3>
                <p>Price: <span style="text-decoration: line-through">₱950</span> <span>₱500</span></p>
                <p>Add some fun to your wardrobe with our Cat Trip Tee! Featuring a trippy cat design</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(13)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(13)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/America War Girl Graphic Print T-shirt Y2k Retro Loose Short Sleeve Round Neck Cotton Top Gothic.jpg" alt="Image 2" data-product-id="14">
            <div class="discount-tag">-33% OFF</div>
            <div class="image-details">
                <h3>Buena Suerte Retro Graphic T-shirt With Dice</h3>
                <p>Price: <span style="text-decoration: line-through">₱750</span> <span>₱500</span></p>
                <p>Buena Suerte! Manifest your fortune with this lucky t-shirt.</p>
            </div>  
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(14)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(14)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/ddownload.jpg" alt="Image 3" data-product-id="15">
            <div class="discount-tag">-33% OFF</div>
            <div class="image-details">
                <h3>Metanoia Studio Inspirational T-Shirt </h3>
                <p>Price: <span style="text-decoration: line-through">₱750</span> <span>₱500</span></p>
                <p>Empower yourself or a loved one with this inspiring T-shirt featuring the uplifting message</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(15)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(15)"></i>
            </div>
        </div>
        <div class="image-container">
            <img src="img/downloadd.jpg" alt="Image 4" data-product-id="16">
            <div class="discount-tag">-47% OFF</div>
            <div class="image-details">
                <h3>Bring me into other horizon Men T-Shirt</h3>
                <p>Price: <span style="text-decoration: line-through">₱950</span> <span>₱500</span></p>
                <p>A Great Conversation Starter: Our sarcastic T-shirts are designed to make an impact and start conversations wherever you go.</p>
            </div>
            <div class="icons">
				<i class="fas fa-heart" onclick="addToFavourite(16)"></i>
				<i class="fas fa-shopping-cart" onclick="addToCart(16)"></i>
          
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br>
    <section id="about">
    <h2 style="text-align: center; font-size: 2em;">About Us</h2>
    <p style="text-align: center; font-size: 1.2em;">Welcome to our shop! We are passionate about providing the best streetwear designs that reflect the latest trends and unique styles. <br>

    <p style="text-align: center;">Welcome to our shop! We are passionate about providing the best streetwear designs that reflect the latest trends and unique styles. <br>
    Our team is dedicated to offering high-quality products at affordable prices. Thank you for choosing us for your fashion needs!</p>
</section>
    <br><br><br><br><br><br><br><br><br>
    <footer id="footer">
        <div class="footer-top">
            <div class="footer-section">
                <h2>CUSTOMER SERVICE</h2>
                <ul>
                    <li><a href="privacypolicy.php">Privacy Policy</a></li>
                    <li><a href="paymentmethod.php">Payment Method</a></li>
                
                </ul>
            </div>
            <div class="footer-section follow-us">
                <h2>FOLLOW US ON</h2>
                <i class="fab fa-facebook-f"></i>
                <i class="fab fa-twitter"></i>
                <i class="fab fa-instagram"></i>
                <i class="fab fa-youtube"></i>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 All rights reserved.</p>
            <p><i class="fas fa-map-marker-alt"></i> Philippines</p>
        </div>
                    
