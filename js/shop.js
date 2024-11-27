window.addEventListener("load", function() {
    const h1Text = "Top Selling Shirts"; 
    let i = 0;
    const h1Speed = 50; 
    const h1 = document.querySelector("h1");
    h1.textContent = "";

    function typeWriter() {
        if (i < h1Text.length) {
            h1.textContent += h1Text.charAt(i);
            i++;
            setTimeout(typeWriter, h1Speed);
        } else {
            h1.style.filter = "none";
        }
    }

    typeWriter();
});
document.addEventListener("DOMContentLoaded", function() {
    const scrollText = document.querySelector("p:last-of-type");
    let colors = ["violet", "red", "lightblue"];
    let colorIndex = 0;
    const colorChangeSpeed = 1000;

    function changeColor() {
        scrollText.style.color = colors[colorIndex];
        colorIndex = (colorIndex + 1) % colors.length;
        setTimeout(changeColor, colorChangeSpeed);
    }

    changeColor();
});
document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll(".image-container img, .fixed-size-img");

    function revealOnScroll() {
        const windowHeight = window.innerHeight;
        images.forEach(img => {
            const imgTop = img.getBoundingClientRect().top;
            const imgBottom = img.getBoundingClientRect().bottom;
            if (imgTop < windowHeight - 100 && imgBottom > 100) {
                img.style.opacity = 1;
            } else {
                img.style.opacity = 0;
            }
        });
    }

    window.addEventListener("scroll", revealOnScroll);
    revealOnScroll();
});
document.addEventListener("DOMContentLoaded", function() {
    const images = document.querySelectorAll(".clickable-image");

    images.forEach(image => {
        image.addEventListener("click", function() {
            if (this.classList.contains("enlarged")) {
                this.classList.remove("enlarged");
            } else {
                images.forEach(img => img.classList.remove("enlarged")); 
                this.classList.add("enlarged");
            }
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const footerImages = document.querySelectorAll(".footer-images .image-container img");

    footerImages.forEach(image => {
        image.addEventListener("click", function() {
            const enlargedImage = document.createElement("div");
            enlargedImage.classList.add("enlarged-image");
            enlargedImage.innerHTML = `
                <div class="enlarged-content">
                    <img src="${this.src}" alt="${this.alt}">
                    <div class="image-details">
                        ${this.nextElementSibling.innerHTML}
                    </div>
                </div>
            `;
            document.body.appendChild(enlargedImage);

            enlargedImage.addEventListener("click", function() {
                document.body.removeChild(enlargedImage);
            });
        });
    });
});
document.addEventListener("DOMContentLoaded", function() {
    const cartIcons = document.querySelectorAll(".fa-shopping-cart");

    cartIcons.forEach(icon => {
        icon.addEventListener("click", function() {
            const imageContainer = this.closest(".image-container");
            const imageUrl = imageContainer.querySelector("img").src;

            let cartItems = JSON.parse(localStorage.getItem("cartItems")) || [];
            cartItems.push({ imageUrl });
            localStorage.setItem("cartItems", JSON.stringify(cartItems));

            const message = document.createElement("div");
            message.classList.add("cart-message");
            message.textContent = "Item added to cart!";
            document.body.appendChild(message);

            setTimeout(() => {
                document.body.removeChild(message);
            }, 2000);
        });
    });
});