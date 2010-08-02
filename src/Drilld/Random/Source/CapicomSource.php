<?php

namespace Drilld\Random\Source;

/**
 * This file is part of the Drilld PHP security framework.
 * Drilld is free software, licensed under the MIT/X11 License. A copy of
 * the license is provided with the library in the LICENSE file.
 */

/**
 * Windows-only COM-based random data source.
 */
class CapicomSource extends AbstractSource
{
    private $comObject = null;

    /**
     * Creates the random data source.
     *
     * If the COM extension is not available and the COM class cannot
     * be found, we throw an exception and finish our business.
     */
    public function __construct()
    {
        // do not try to autoload here!
        if (class_exists('COM', false))
        {
            try
            {
                // Microsoft says this is now deprecated
                $this->comObject = new \COM('CAPICOM.Utilities.1');
            }
            catch (\Exception $e)
            {
                throw \Drilld\Exception::wrap($e);
            }
        }
        else
        {
            throw new \Drilld\Exception('COM class not found');
        }
    }

    /**
     * Returns $length bytes of random data.
     *
     * @param int $length length of the requested random sequence in bytes
     * @return string random binary data
     */
    public function getData($length)
    {
        try
        {
            $bits = $this->comObject->GetRandom($length, 0);
            // as $bits are binary data, PHP encodes it with base64
            return \base64_decode($bits);
        }
        catch (\Exception $e)
        {
            throw \Drilld\Exception::wrap($e);
        }
    }
}
