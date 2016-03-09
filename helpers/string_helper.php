<?php  if ( ! defined('BASEROOT')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright		Copyright (c) 2008 - 2014, EllisLab, Inc.
 * @copyright		Copyright (c) 2014 - 2015, British Columbia Institute of Technology (http://bcit.ca/)
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter String Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		http://codeigniter.com/user_guide/helpers/string_helper.html
 */

// ------------------------------------------------------------------------

/**
 * Trim Slashes
 *
 * Removes any leading/trailing slashes from a string:
 *
 * /this/that/theother/
 *
 * becomes:
 *
 * this/that/theother
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('trim_slashes'))
{
	function trim_slashes($str)
	{
		return trim($str, '/');
	}
}

// ------------------------------------------------------------------------

/**
 * Strip Slashes
 *
 * Removes slashes contained in a string or in an array
 *
 * @access	public
 * @param	mixed	string or array
 * @return	mixed	string or array
 */
if ( ! function_exists('strip_slashes'))
{
	function strip_slashes($str)
	{
		if (is_array($str))
		{
			foreach ($str as $key => $val)
			{
				$str[$key] = strip_slashes($val);
			}
		}
		else
		{
			$str = stripslashes($str);
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Strip Quotes
 *
 * Removes single and double quotes from a string
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('strip_quotes'))
{
	function strip_quotes($str)
	{
		return str_replace(array('"', "'"), '', $str);
	}
}

// ------------------------------------------------------------------------

/**
 * Quotes to Entities
 *
 * Converts single and double quotes to entities
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('quotes_to_entities'))
{
	function quotes_to_entities($str)
	{
		return str_replace(array("\'","\"","'",'"'), array("&#39;","&quot;","&#39;","&quot;"), $str);
	}
}

// ------------------------------------------------------------------------

/**
 * Reduce Double Slashes
 *
 * Converts double slashes in a string to a single slash,
 * except those found in http://
 *
 * http://www.some-site.com//index.php
 *
 * becomes:
 *
 * http://www.some-site.com/index.php
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('reduce_double_slashes'))
{
	function reduce_double_slashes($str)
	{
		return preg_replace("#(^|[^:])//+#", "\\1/", $str);
	}
}

// ------------------------------------------------------------------------

/**
 * Reduce Multiples
 *
 * Reduces multiple instances of a particular character.  Example:
 *
 * Fred, Bill,, Joe, Jimmy
 *
 * becomes:
 *
 * Fred, Bill, Joe, Jimmy
 *
 * @access	public
 * @param	string
 * @param	string	the character you wish to reduce
 * @param	bool	TRUE/FALSE - whether to trim the character from the beginning/end
 * @return	string
 */
if ( ! function_exists('reduce_multiples'))
{
	function reduce_multiples($str, $character = ',', $trim = FALSE)
	{
		$str = preg_replace('#'.preg_quote($character, '#').'{2,}#', $character, $str);

		if ($trim === TRUE)
		{
			$str = trim($str, $character);
		}

		return $str;
	}
}

// ------------------------------------------------------------------------

/**
 * Create a Random String
 *
 * Useful for generating passwords or hashes.
 *
 * @access	public
 * @param	string	type of random string.  basic, alpha, alunum, numeric, nozero, unique, md5, encrypt and sha1
 * @param	integer	number of characters
 * @return	string
 */
if ( ! function_exists('random_string'))
{
	function random_string($type = 'alnum', $len = 8)
	{
		switch($type)
		{
			case 'basic'	: return mt_rand();
				break;
			case 'alnum'	:
			case 'numeric'	:
			case 'nozero'	:
			case 'alpha'	:

					switch ($type)
					{
						case 'alpha'	:	$pool = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
						case 'alnum'	:	$pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
							break;
						case 'numeric'	:	$pool = '0123456789';
							break;
						case 'nozero'	:	$pool = '123456789';
							break;
					}

					$str = '';
					for ($i=0; $i < $len; $i++)
					{
						$str .= substr($pool, mt_rand(0, strlen($pool) -1), 1);
					}
					return $str;
				break;
			case 'unique'	:
			case 'md5'		:

						return md5(uniqid(mt_rand()));
				break;
			case 'encrypt'	:
			case 'sha1'	:

						//$CI =& get_instance();
						//$CI->load->helper('security');
						//return do_hash(uniqid(mt_rand(), TRUE), 'sha1');
				break;
		}
	}
}

// ------------------------------------------------------------------------

/**
 * Add's _1 to a string or increment the ending number to allow _2, _3, etc
 *
 * @param   string  $str  required
 * @param   string  $separator  What should the duplicate number be appended with
 * @param   string  $first  Which number should be used for the first dupe increment
 * @return  string
 */
function increment_string($str, $separator = '_', $first = 1)
{
	preg_match('/(.+)'.$separator.'([0-9]+)$/', $str, $match);

	return isset($match[2]) ? $match[1].$separator.($match[2] + 1) : $str.$separator.$first;
}

// ------------------------------------------------------------------------

/**
 * Alternator
 *
 * Allows strings to be alternated.  See docs...
 *
 * @access	public
 * @param	string (as many parameters as needed)
 * @return	string
 */
if ( ! function_exists('alternator'))
{
	function alternator()
	{
		static $i;

		if (func_num_args() == 0)
		{
			$i = 0;
			return '';
		}
		$args = func_get_args();
		return $args[($i++ % count($args))];
	}
}

// ------------------------------------------------------------------------

/**
 * Repeater function
 *
 * @access	public
 * @param	string
 * @param	integer	number of repeats
 * @return	string
 */
if ( ! function_exists('repeater'))
{
	function repeater($data, $num = 1)
	{
		return (($num > 0) ? str_repeat($data, $num) : '');
	}
}

function validation_filter_id_card($id_card) 
{ 
    if(strlen($id_card) == 18) 
    { 
        return idcard_checksum18($id_card); 
    } 
    elseif((strlen($id_card) == 15)) 
    { 
        $id_card = idcard_15to18($id_card); 
        return idcard_checksum18($id_card); 
    } 
    else 
    { 
        return false; 
    } 
} 

// 计算身份证校验码，根据国家标准GB 11643-1999 
function idcard_verify_number($idcard_base) 
{ 
    if(strlen($idcard_base) != 17) 
    { 
        return false; 
    } 
    //加权因子 
    $factor = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); 
    //校验码对应值 
    $verify_number_list = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); 
    $checksum = 0; 
    for ($i = 0; $i < strlen($idcard_base); $i++) 
    { 
        $checksum += substr($idcard_base, $i, 1) * $factor[$i]; 
    } 
    $mod = $checksum % 11; 
    $verify_number = $verify_number_list[$mod]; 
    return $verify_number; 
} 

// 将15位身份证升级到18位 
function idcard_15to18($idcard){ 
    if (strlen($idcard) != 15){ 
        return false; 
    }else{ 
        // 如果身份证顺序码是996 997 998 999，这些是为百岁以上老人的特殊编码 
        if (array_search(substr($idcard, 12, 3), array('996', '997', '998', '999')) !== false){ 
            $idcard = substr($idcard, 0, 6) . '18'. substr($idcard, 6, 9); 
        }else{ 
            $idcard = substr($idcard, 0, 6) . '19'. substr($idcard, 6, 9); 
        } 
    } 
    $idcard = $idcard . idcard_verify_number($idcard); 
    return $idcard; 
} 

// 18位身份证校验码有效性检查 
function idcard_checksum18($idcard){ 
    if (strlen($idcard) != 18){ return false; } 
    $idcard_base = substr($idcard, 0, 17); 
    if (idcard_verify_number($idcard_base) != strtoupper(substr($idcard, 17, 1))){ 
        return false; 
    }else{ 
        return true; 
    } 
} 

if ( ! function_exists('getOS')){
	function getOS(){
		$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
		if(strpos($agent, 'windows nt')) {
			$platform = 'windows';
		} elseif(strpos($agent, 'macintosh')) {
			$platform = 'mac';
		} elseif(strpos($agent, 'ipod')) {
			$platform = 'ipod';
		} elseif(strpos($agent, 'ipad')) {
			$platform = 'ipad';
		} elseif(strpos($agent, 'iphone')) {
			$platform = 'iphone';
		} elseif (strpos($agent, 'android')) {
			$platform = 'android';
		} elseif(strpos($agent, 'unix')) {
			$platform = 'unix';
		} elseif(strpos($agent, 'linux')) {
			$platform = 'linux';
		} else {
			$platform = 'other';
		}
		return $platform;
	}
}

/* End of file string_helper.php */
/* Location: ./system/helpers/string_helper.php */
