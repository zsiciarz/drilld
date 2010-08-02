<?php

namespace Drilld\Crypt;

use Drilld\Hash;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * A converter from human-readable key to something usable for encryption.
 */
class Key
{
    private $key = '';

    /**
     * Converts the key to a value more suitable for encryption.
     *
     * Most human-readable keys are pretty weak as they use only alphanumeric
     * characters. This utility class converts such key to an 8-bit form,
     * which uses full byte value range (0-255). It also fits the key
     * to some fixed length, probably enforced by encryption algorithm.
     *
     * @param string $humanKey a human-readable key
     * @param int $length desired key length
     * @param string $algorithm which hashing algorithm to use (default: SHA-1)
     */
    public function __construct($humanKey, $length, $algorithm = 'sha1')
    {
        // We have to calculate, how many raw outputs from hashing function
        // will fit into $length. Then we split the supplied string into
        // exactly $hashCount chunks.
        // 20 is number of bytes returned by SHA-1 in raw form
        // TODO: move the constant to Hash, as a method like Hash::getRawSize()
        $hashSize = 20;
        $hashCount = \ceil($length / $hashSize);
        $chunkSize = \ceil(\strlen($humanKey) / $hashCount);
        $chunks = \str_split($humanKey, $chunkSize);

        // concatenate all chunk hashes to create the final key
        foreach ($chunks as $chunk)
        {
            $hash = new Hash\Hash($algorithm);
            $hash->update($chunk);
            $this->key .= $hash->digest();
        }

        // at the end we make sure the key length is exactly as needed
        $this->key = \substr($this->key, 0, $length);
    }

    /**
     * Returns a converted key.
     * 
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }
}
