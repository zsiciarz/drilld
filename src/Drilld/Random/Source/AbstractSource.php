<?php

namespace Drilld\Random\Source;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * A base class for all random data sources.
 */
abstract class AbstractSource
{
    /**
     * Should return $length bytes of random data.
     *
     * @param int $length length of the requested random sequence in bytes
     * @return string random binary data
     */
    abstract public function getData($length);
}
