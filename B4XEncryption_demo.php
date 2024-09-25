<?php
/**
 * Demo form B4XEncryption.php module
 * 
 * Expected results:
 * 
 * Decrypted: mystring
 * test text xyz
 * sBKN1Uhs2LIkwL8uVDkhDjnzCSsIUK6e2eAKFSiXVrmrtI1K7s05XQ==  (not exactly the same) :-)
 * test text xyz
 */
 

include_once "B4XEncryption.php";
$pw='pwd';  //test password
/*
	'Encrypt
	Dim Cipher As B4XCipher
	Dim s As String = "mystring"
	Dim b() As Byte = Cipher.Encrypt(s.GetBytes("UTF8"), "pwd")
	Dim b1 As String = su.EncodeBase64(b)
    Log(s)

    Log(b1) 'copy to %b1

    'Decrypt
	Dim b2() As Byte = su.DecodeBase64(b1)
    Dim bb() As Byte = Cipher.Decrypt(b2, "pwd")
	Dim ss As String = BytesToString(bb, 0, bb.Length, "UTF8")
    Log(ss)
    
*/


$b1="Tytwwd1Tov4P4ioNjPmaxMWQT6WxEd8xBBeDnIwWy2iL9qNG6JAtVA=="; // text copied from B4X example result (b1)
print PHP_EOL."Decrypted: ".B4X_Decrypt($b1, $pw).PHP_EOL; //just for a test


// encrypt - decrypt test

$text="test text xyz";
$enc=B4X_Encrypt($text,$pw);$dec="";
$dec=B4X_Decrypt($enc ,$pw);
print $text.PHP_EOL.$enc.PHP_EOL.$dec.PHP_EOL.PHP_EOL;
?>