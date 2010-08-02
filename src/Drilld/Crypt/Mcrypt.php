<?php

namespace Drilld\Crypt;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * A wrapper for PHP mcrypt module.
 */
class Mcrypt implements CryptInterface
{
    private $algorithm = '';

    private $mode = '';

    private $module = null;

    private $iv = '';

    /**
     * Initializes the Mcrypt object.
     *
     * For a detailed description of parameters, see
     * http://www.php.net/manual/en/function.mcrypt-module-open.php .
     *
     * @param string $algorithm the algorithm to use
     * @param string $mode encryption mode
     */
    public function __construct($algorithm, $mode = 'cfb')
    {
        $this->algorithm = $algorithm;
        $this->mode = $mode;

        $this->module = \mcrypt_module_open($this->algorithm, '',
                                            $this->mode, '');
    }

    public function  __destruct()
    {
        \mcrypt_module_close($this->module);
    }

    /**
     * Returns algorithm name.
     *
     * @return string
     */
    public function getAlgorithmName()
    {
        return $this->algorithm;
    }

    /**
     * Returns encryption mode.
     *
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Returns the maximum supported key size for current algorithm and mode.
     * 
     * @return int
     */
    public function getKeySize()
    {
        return \mcrypt_enc_get_key_size($this->module);
    }

    /**
     * Returns the IV size for current algorithm and mode.
     *
     * @return int
     */
    public function getIvSize()
    {
        return \mcrypt_enc_get_iv_size($this->module);
    }

    /**
     * Returns most recently used initialization vector.
     *
     * @return string
     */
    public function getIv()
    {
        return $this->iv;
    }

    /**
     * Sets a custom initialization vector (IV).
     *
     * Mostly used for decryption.
     *
     * @param string $iv
     */
    public function setIv($iv)
    {
        $this->iv = $iv;
    }


    /**
     * Encrypts the data with a given key.
     *
     * @param mixed $data arbitrary data to encrypt
     * @param string $key secret key used for encryption
     * @return encrypted data
     */
    public function encrypt($data, $key)
    {
        $betterKey = $this->convertKey($key);
        $this->iv = \mcrypt_create_iv($this->getIvSize());
        \mcrypt_generic_init($this->module, $betterKey, $this->iv);
        $encryptedData = \mcrypt_generic($this->module, $data);
        \mcrypt_generic_deinit($this->module);

        return $encryptedData;
    }

    /**
     * Decrypts the data with a given key.
     *
     * If the IV is not given, the method makes use of a most recently used
     * one.
     *
     * @param mixed $data arbitrary data to decrypt
     * @param string $key secret key used for decryption
     * @param string $iv an optional initialization vector
     * @return decrypted data
     */
    public function decrypt($data, $key, $iv = null)
    {
        if (!is_null($iv))
        {
            $this->setIv($iv);
        }

        $betterKey = $this->convertKey($key);
        \mcrypt_generic_init($this->module, $betterKey, $this->iv);
        $decryptedData = \mdecrypt_generic($this->module, $data);
        \mcrypt_generic_deinit($this->module);

        return $decryptedData;
    }

    /**
     * Converts the user-supplied key to a more strong one.
     *
     * @param string $key
     * @return string
     */
    private function convertKey($key)
    {
        $keyObject = new \Drilld\Crypt\Key($key, $this->getKeySize());

        return $keyObject->getKey();
    }
}
