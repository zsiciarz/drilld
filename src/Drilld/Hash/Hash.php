<?php

namespace Drilld\Hash;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * A simple object-oriented wrapper for PHP hash library.
 */
class Hash
{
    private $name = '';
    
    private $ctx = null;

    /**
     * Returns names of available hashing algorithms.
     *
     * @return array an array of algorithm names
     */
    static public function algos()
    {
        return hash_algos();
    }

    /**
     * Creates a Hash object, using given algorithm.
     *
     * @param string $name algorithm name (eg. 'md5', 'whirlpool' etc.)
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->ctx = hash_init($name);
    }

    /**
     * Returns the name of currently used algorithm.
     *
     * @return string algorithm name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Updates the hash with new data.
     *
     * Can be used for incremental hashing, for example when streaming a large
     * file from the Internet.
     * 
     * @param mixed $data
     */
    public function update($data)
    {
        hash_update($this->ctx, $data);
    }

    /**
     * Returns the hash digest.
     *
     * What is returned is raw binary data, not the hexadecimal representation.
     * For that, see hexdigest().
     *
     * @return string binary digest
     */
    public function digest()
    {
        return hash_final($this->ctx, true);
    }

    /**
     * Returns the hash digest as a hexadecimally encoded string.
     *
     * @return string the hex-encoded digest
     */
    public function hexdigest()
    {
        return hash_final($this->ctx);
    }
}
