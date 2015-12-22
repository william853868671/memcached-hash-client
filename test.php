<?php
include 'FiexiHash.php';

$hash = new FiexiHash();
$port = 11211;
//普通的hash 分布
$servers = array(
	array('host'=>'192.168.1.1','port'=>$port),
	array('host'=>'192.168.1.2','port'=>$port)
	);
$key = 'TheKey';
$value = 'TheValue';
$sc = $servers[$hash->mHash($key) %2];
$memcached = new memcached($sc);
$memcached->set($key,$value);
//一致性的hash分布
$serverList = array(
	$hash->addServer('192.168.1.1'),
	$hash->addServer('192.168.1.2'),
	$hash->addServer('192.168.1.3'),
	$hash->addServer('192.168.1.4'),
	$hash->addServer('192.168.1.5'),
	);
var_dump($hash->lookUp('key1'));
var_dump($hash->lookUp('key2'));
$memcached = new memcached();
$memcached -> connect($serverList[0],$port);
$memcached->set('key1','value1');
?>