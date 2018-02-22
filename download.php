<?php
$filename = $_GET['download'];
$path = __DIR__ . "/Downloads/" . $filename;
header('Content-disposition: attachment; filename="'.$filename.'"');
header("Content-type: application/mp4");
readfile($path);
exit;
?>