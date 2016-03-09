<?php  if ( ! defined('BASEROOT')) exit('No direct script access allowed');


if ( ! function_exists('ajax_success') ) {

    function ajax_success($data,$msg,$code = 200) {
        if ( !is_array($data) ) $data=$data;
        header('Content-type:text/json; charset=utf-8');
        echo json_encode(array("code"=>$code,'data'=>$data,"errMsg"=>$msg));exit;
    }

}

if ( ! function_exists('ajax_error') ) {

    function ajax_error($code,$msg) {
        header('Content-type:text/json; charset=utf-8');
        echo json_encode(array("code"=>$code,"errMsg"=>$msg));exit;
    }

}

if ( ! function_exists('money_formatByStr') ) {
    function money_formatByStr($number,$index = 2){
        return  number_format($number,$index);
    }
}
