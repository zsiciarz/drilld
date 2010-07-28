<?php

namespace Drilld\Random\Source;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * A random data source for *nix systems using /dev/random or /dev/urandom.
 */
class DevRandomSource extends AbstractSource
{
    private $device = '';

    private $fp = null;

    /**
     * Creates the random data source.
     *
     * The default random device from which data will be read is /dev/random.
     * On Linux systems, this device is cryptographically secure, but read
     * operations are blocking. You can set the device to /dev/urandom, which
     * is faster, but has less entropy.
     *
     * @param string $device which device file to use
     */
    public function __construct($device = '/dev/random')
    {
        $this->device = $device;
        $this->fp = @fopen($this->device, 'rb');
        if (false === $this->fp)
        {
            throw new \Drilld\Exception(sprintf('Failed to open %s', $this->device));
        }
    }

    /**
     * Closes the file handle at the destruction of the source object.
     *
     * Cannot throw exceptions here!
     */
    public function __destruct()
    {
        @fclose($this->fp);
    }

    /**
     * Returns $length bytes of random data.
     *
     * @param int $length length of the requested random sequence in bytes
     * @return string random binary data
     */
    public function getData($length)
    {
        $data = fread($this->fp, $length);
        if (false === $this->fp)
        {
            throw new \Drilld\Exception(sprintf('Failed to read from %s', $this->device));
        }

        return $data;
    }
}
