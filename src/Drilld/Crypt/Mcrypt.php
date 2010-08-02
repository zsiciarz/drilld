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
     * Encrypts the data with a given key.
     *
     * @param mixed $data arbitrary data to encrypt
     * @param string $key secret key used for encryption
     * @return encrypted data
     */
    public function encrypt($data, $key)
    {
        // TODO
    }

    /**
     * Decrypts the data with a given key.
     *
     * @param mixed $data arbitrary data to decrypt
     * @param string $key secret key used for decryption
     * @return decrypted data
     */
    public function decrypt($data, $key)
    {
        // TODO
    }
}
