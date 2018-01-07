<?php
/**
 * Namespace for all core classes of PicVid.
 */
namespace PicVid\Core;

/**
 * Class Encryption
 *
 * @author Sebastian Brosch <coding@sebastianbrosch.de>
 * @license GNU General Public License, version 3
 * @package PicVid\Core
 */
class Encryption
{
    /**
     * The encryption method to encrypt and decrypt the information.
     * @see http://php.net/manual/en/function.openssl-get-cipher-methods.php
     * @var string
     */
    private $method = '';

    /**
     * The security key to encrypt and decrypt the information.
     * @var string
     */
    private $key = '';

    /**
     * Encryption constructor.
     * @param string $method The encryption method to encrypt and decrypt the information.
     * @param string $key The security key to encrypt and decrypt the information.
     */
    public function __construct(string $method, string $key)
    {
        //check if the encryption method exists.
        if (in_array($method, openssl_get_cipher_methods())) {
            $this->method = $method;
        } else {
            $this->method = '';
        }

        //set the security key.
        $this->key = $key;
    }

    /**
     * Method to decrypt the information.
     * @param string $value The value which will be decrypted.
     * @return string The decrypted information.
     */
    public function decrypt(string $value) : string
    {
        //split the decrypted value in initialization vector and data.
        $data = preg_split('/\./', base64_decode($value));

        //check if the initialization vector and data part is available.
        if (count($data) !== 2) {
            return '';
        }

        //decrypt the data.
        $value = openssl_decrypt($data[1], $this->method, $this->key, 0, $data[0]);

        //return the decrypted value.
        return ($value === false) ? '' : $value;
    }

    /**
     * Method to encrypt the information.
     * @param string $value The value which will be encrypted.
     * @return string The encrypted information with the leading initialization vector.
     */
    public function encrypt(string $value) : string
    {
        //encrypt the value.
        $iv = $this->getRandomIV();
        $value = base64_encode($iv.'.'.openssl_encrypt($value, $this->method, $this->key, 0, $iv));

        //return the encrypted information.
        return ($value === false) ? '' : $value;
    }

    /**
     * Method to get the initialization vector for the specified encryption method.
     * @return string The initialization vector for the specified encryption method.
     */
    private function getRandomIV()
    {
        $iv_length = openssl_cipher_iv_length($this->method);
        $secret_iv = openssl_random_pseudo_bytes($iv_length);
        return substr(hash('sha256', $secret_iv), 0, $iv_length);
    }

    /**
     * Method to get a random generated security key.
     * @return string The random generated security key.
     */
    public static function getRandomKey()
    {
        return  hash('sha256', openssl_random_pseudo_bytes(128));
    }
}