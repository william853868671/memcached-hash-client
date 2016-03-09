<?php

/**
 * 防刷机制：字符串加密/解密
 * @param $string string 待操作字符串
 * @param $operation string 处理方式（ DECODE：解密，其他：加密）
 * @param $key string 密钥(ZNT_KEY：自定义密钥)
 * @param $expiry int 密钥有效期（默认：0  永不过期）
 * @return string 加密或解密后的字符串 
 */
function checkBrush($string, $operation = '', $key = '', $expiry = 0) {
	$ckey_length = 4;
    $key = md5($key ? $key : ZNT_KEY); 
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    
    if($operation == 'DECODE') {
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

/*//测试
echo '加密前：hxy123<br>';
$pb = checkBrush('hxy123','','abc123',1);
echo '加密后：'.$pb.'<br>';
//sleep(1);
$pb2 = checkBrush($pb,'DECODE','abc123');
echo '解密后：'.$pb2;*/
