<?php

namespace Drilld\Crypt;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * CryptInterface must be implemented by all encryption/decryption classes.
 */
interface CryptInterface
{
    /**
     * Encrypts the data with a given key.
     *
     * @param mixed $data arbitrary data to encrypt
     * @param string $key secret key used for encryption
     * @return encrypted data
     */
    public function encrypt($data, $key);

    /**
     * Decrypts the data with a given key.
     *
     * @param mixed $data arbitrary data to decrypt
     * @param string $key secret key used for decryption
     * @return decrypted data
     */
    public function decrypt($data, $key);
}
