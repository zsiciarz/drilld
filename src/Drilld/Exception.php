<?php

namespace Drilld;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * Exception class.
 */
class Exception extends \Exception
{
    static public function wrap(\Exception $e)
    {
        return new self($e->getMessage(), $e->getCode(), $e->getPrevious());
    }
}
