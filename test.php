<?php
include 'Template.php';
//$tpl = new Template();
//var_dump($tpl->show('1231'));

$hash = new FiexiHash();
//var_dump($hash->mHash('192.168.1.1'));

$servers = array(
	array('host'=>'192.168.1.1','port'=>6397),
	array('host'=>'192.168.1.2','port'=>6397)
	);
$key = 'TheKey';
$value = 'TheValue';
$sc = $servers[$hash->mHash($key) %2];
var_dump($sc);
$hash->addServer('192.168.1.1');
$hash->addServer('192.168.1.2');
$hash->addServer('192.168.1.3');
$hash->addServer('192.168.1.4');
$hash->addServer('192.168.1.5');
var_dump($hash->lookUp('key1'));
?>