<?php
    $encryption_key = 'secret_key_1234abcdef';
    $cipher = 'aes-256-cbc';
    $files = glob('uploads/*.enc');

    foreach ($files as $file) {
        $data = base64_decode(file_get_contents($file));

        $iv = substr($data, 0, openssl_cipher_iv_length($cipher));
        $encrypted = substr($data, openssl_cipher_iv_length($cipher));

        $decrypted = openssl_decrypt($encrypted, $cipher, $encryption_key, 0, $iv);

        $originalName = basename($file, '.enc');
        $decryptedFile = 'decrypted/' . $originalName;
        file_put_contents($decryptedFile, $decrypted);

        echo "<a href='$decryptedFile' download>$originalName</a><br>";
    }
?>