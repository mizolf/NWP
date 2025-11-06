<?php
    $conn = new mysqli('localhost', 'root', '', 'lv2');
    $res = $conn->query("SELECT * FROM osobe");

    $filename = "backup.txt";
    $backup = "";

    while ($row = $res->fetch_assoc()) {
        $backup .= "INSERT INTO osobe (id, ime, prezime, email) VALUES ('{$row['id']}', '{$row['ime']}', '{$row['prezime']}', '{$row['email']}');\n";
    }

    file_put_contents($filename, $backup);

    $zip = new ZipArchive();
    $zipFile = "backup.zip";
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        $zip->addFile($filename);
        $zip->close();
    }
?>