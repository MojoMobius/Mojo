<?php 
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

$fp = fopen("sample.html","r");
$strContent = fread($fp, filesize("sample.html"));
fclose($fp);

//$mpdf->WriteHTML('<h1>Hello world!</h1>');
$mpdf->WriteHTML($strContent);

$mpdf->Output();
?>