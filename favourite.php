<?php
// favourite.php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo "Added to favourite";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <script>
        function addToFavourite() {
            fetch('favourite.php', {
                method: 'POST'
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById('message').innerText = data;
            });
        }
    </script>
</head>
<body>
    <div>
        <button onclick="addToFavourite()">❤️</button>
        <p id="message"></p>
    </div>
</body>
</html>