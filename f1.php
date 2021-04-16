<?php
/*
http://localhost/zuikis/f1.php    <----   kelias narsyklei
C:\xampp\htdocs\zuikis\f1.php      <----- kelias serveriui (__DIR__)

*/

_d($_SERVER);

_d(
$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI']
);

echo 'Labas';
echo '<br>';
echo __DIR__; // <--- stebuklinga TIK SERVERIUI!!!!
echo '<br>';
require_once __DIR__.'/f2.php';
echo '<br>';
require_once __DIR__.'/f2.php';



echo '<br>';
echo 'VISKAS OK';