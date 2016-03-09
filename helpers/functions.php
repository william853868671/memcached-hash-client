<?php
/**
 * 获取和设置配置参数 支持批量定义
 * @param string|array $name 配置变量
 * @param mixed $value 配置值
 * @param mixed $default 默认值
 * @return mixed
 */
if(!function_exists(C)){
    function C($name = null, $value = null, $default = null)
    {
        static $_config = array();
        // 无参数时获取所有
        if (empty($name)) {
            return $_config;
        }
        // 优先执行设置获取或赋值
        if (is_string($name)) {
            if (!strpos($name, '.')) {
                $name = strtoupper($name);
                if (is_null($value)) {
                    return isset($_config[$name]) ? $_config[$name] : $default;
                }
                $_config[$name] = $value;
                return null;
            }
            // 二维数组设置和获取支持
            $name    = explode('.', $name);
            $name[0] = strtoupper($name[0]);
            if (is_null($value)) {
               
                return isset($_config[$name[0]][$name[1]]) ? $_config[$name[0]][$name[1]] : $default;
            }
           
            $_config[$name[0]][$name[1]] = $value;
            return null;
        }
        // 批量设置
        if (is_array($name)) {
            $_config = array_merge($_config, array_change_key_case($name, CASE_UPPER));
            return null;
        }
        return null; // 避免非法参数
    }    
}

/**
 * 检测邮箱是否正确 为了判断取反，正确返回false,不正确返回true
 * @param $mail
 */
function check_mail($mail){
    $pattern = '/^\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/i';
    $result = preg_match($pattern, $mail);
    if ($result) {
        return false;
    } else {
        return true;
    }
}
/**
 * 检测是否为正确url地址 为了判断取反，正确返回false,不正确返回true
 * @param $mail
 */
function check_url($url){
    $pattern = '/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i';
    $result = preg_match($pattern, $url);
    if ($result) {
        return false;
    } else {
        return true;
    }
}
/**
 * 检测手机号是否正确 为了判断取反，正确返回false，不正确返回true
 * @param $phone
 */
function check_phone($phone){
    $pattern = '/^(13\d{9})|(15[0-35-9]\d{8})|(17[0-35-9]\d{8})|(18[0-9]\d{8})$/';
    $result = preg_match($pattern, $phone);
    if ($result) {
        return false;
    } else {
        return true;
    }
}
/**
 * 检测是否为数字
 * @param $num
 */
function check_num($num){
    $result = is_numeric($num);
    if ($result) {
        return false;
    } else {
        return true;
    }
}
/**
 * 检测时间是否有效
 * @param $str
 * @param $format
 */
function check_time($str, $format="Y-m-d H:i:s"){
    $unixTime=strtotime($str);
    $checkDate= date($format, $unixTime);
    if($checkDate == $str){
        return true;
    } else {
        return false;
    }
}

