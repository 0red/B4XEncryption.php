/**
 *  JS equivalent for B4X B4XEncryption libray
 * 
 * @version 1.0
 * @author Jacek Rusin
 * @license GPLv3
 * @link https://www.gnu.org/licenses/gpl-3.0.html
 * @requires crypto-js
 * @example
 * <!DOCTYPE html>
 * <html>
 *  <head>
 *      <meta charset="UTF-8" />
 *      <script type="text/javascript" src="bower_components/crypto-js/crypto-js.js"></script>
 *      <script type="text/javascript" src="B4XEncryption.js"></script>
 *  </head>
 *  <body>
 *    <script type="text/javascript">
 *      var t="Jacek ąśżźćń",pwd="pwd";
 *      console.log("t0:",t);
 *      t1=B4X_Encrypt(t,pwd)
 *      console.log("t1:"+t1);
 *      t2=B4X_Decrypt(t1,pwd)
 *      console.log("t2:"+t2);
 *    </script>
 *  </body>
 * </html>
 */


function B4X_keygen_salt(_passphrase,_salt,_keySize=8,_iterations=1024,_hasher=CryptoJS.algo.SHA1) {
    return CryptoJS.PBKDF2(
       _passphrase,
       _salt,
       { keySize: 4, 
         hasher: CryptoJS.algo.SHA1,
         iterations: 1024,
       }
   );
}

function B4X_Encrypt(plaintext_to_encode, password, base64_output=true) {
   let salt,iv,pw1,enc,res
   salt= CryptoJS.enc.Utf8.parse("12345678") 
   salt= CryptoJS.lib.WordArray.random(8);
   iv  = CryptoJS.lib.WordArray.random(16);
   pw1 = B4X_keygen_salt(CryptoJS.enc.Utf8.parse(password), salt)
   enc = CryptoJS.AES.encrypt(
           CryptoJS.enc.Utf8.parse(plaintext_to_encode), pw1, { 
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC,
         }).ciphertext;
   res = (salt.concat(iv)).concat(enc);
   return base64_output ? res.toString(CryptoJS.enc.Base64) : res;
}

function B4X_Decrypt(text_to_decode, password, base64_input=true) {
   let txt,salt,iv,pw1,res
   txt = base64_input ? CryptoJS.enc.Base64.parse(text_to_decode) : CryptoJS.enc.Utf8.parse(text_to_decode);
   txt = CryptoJS.enc.Hex.stringify(txt);
   salt= CryptoJS.enc.Hex.parse(txt.slice(0,16));
   iv  = CryptoJS.enc.Hex.parse(txt.slice(16,48));
   txt = CryptoJS.enc.Hex.parse(txt.slice(48));
   pw1 = B4X_keygen_salt(CryptoJS.enc.Utf8.parse(password), salt);
   res = CryptoJS.AES.decrypt(
          {ciphertext: txt}, pw1, { 
            iv: iv,
            padding: CryptoJS.pad.Pkcs7,
            mode: CryptoJS.mode.CBC,
         });
   return res.toString(CryptoJS.enc.Utf8);
}