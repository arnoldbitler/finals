document.addEventListener("DOMContentLoaded", function() {
    const textElement = document.querySelector(".random-text");
    const text = textElement.textContent;
    textElement.textContent = "";
    let index = 0;

    function typeWriter() {
        if (index < text.length) {
            textElement.textContent += text.charAt(index);
            textElement.style.filter = `blur(${5 - (index / text.length) * 5}px)`;
            index++;
            setTimeout(typeWriter, 50);
        } else {
            textElement.style.filter = "blur(0px)";
        }
    }

    typeWriter();
});

document.addEventListener("DOMContentLoaded", function() {
    const buttonElement = document.querySelector(".button");
    buttonElement.style.transition = "transform 1.5s ease, opacity 1.5s ease"; 
    
    setTimeout(() => {
        buttonElement.style.transform = "translateY(0)";
        buttonElement.style.opacity = "1";
    }, 3500); 
});