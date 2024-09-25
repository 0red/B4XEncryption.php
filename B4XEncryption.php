<?php
/**
 * PHP equivalent for B4X B4XEncryption libray
 * 
 * @version 1.0
 * @author Jacek Rusin
 * @license GPLv3
 * @link https://www.gnu.org/licenses/gpl-3.0.html
 * 
 */


 
/**
 * B4X_Decrypt
 * PHP equivalent for Cipher.Decrypt function B4X B4XEncryption libray
 *
 * @param  mixed $b4x_encrypted_string
 * @param  mixed $password
 * @param  mixed $base64_input
 * @return void
 */
function B4X_Decrypt($b4x_encrypted_string, $password, $base64_input=true) {
    $temp= ($base64_input) ?base64_decode($b4x_encrypted_string) : $b4x_encrypted_string;
    $salt= substr($temp, 0, 8);
    $iv  = substr($temp, 8, 16);
	$text= substr($temp, 8+16, strlen($temp)-8-16);
	$pw1 = openssl_pbkdf2($password, $salt, 16, 1024, "sha1");
    try {
        $res = openssl_decrypt($text, "AES-128-CBC", $pw1, OPENSSL_RAW_DATA, $iv);
    } catch (Exception) {
        $res = false;
    }
    return $res;
}



/**
 * pkcs7pad
 * Add PKCS7 padding to the given text
 *
 * @param  mixed $plaintext
 * @param  mixed $blocksize 16:AES-128 24:AES-192 32:AES-256
 * @return string return $plaintext with PKCS7 padding
 */
function pkcs7pad($plaintext, $blocksize)
{
    $padsize = $blocksize - (strlen($plaintext) % $blocksize);
    return $plaintext . str_repeat(chr($padsize), $padsize);
}



/**
 * B4X_Encrypt
 * PHP equivalent for Cipher.Encrypt function B4X B4XEncryption libray
 * 
 * @param  mixed $stplaintext_to_encode
 * @param  mixed $password
 * @param  mixed $base64_output - if true output will be in base64
 * @return string B4X compatible encoded string or base64 equivalent
 */
function B4X_Encrypt($plaintext_to_encode, $password, $base64_output=true) {
    $salt= openssl_random_pseudo_bytes(8);
    $iv  = openssl_random_pseudo_bytes(16);
	$pw1 = openssl_pbkdf2($password, $salt, 16, 1024, "sha1");
    $enc = openssl_encrypt($plaintext_to_encode, "AES-128-CBC", $pw1, OPENSSL_RAW_DATA, $iv);
    $res = $salt.$iv.$enc;
	return ($base64_output) ? base64_encode($res) : $res;
}
?>