<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\Money;

/**
 * All money converter readers should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface MoneyPropertyConverterReaderInterface
{
    /**
     * Is property supported
     *
     * @param \ReflectionProperty $property
     *
     * @return bool
     */
    public function isSupported(\ReflectionProperty $property);

    /**
     * Load metadata
     *
     * @param \ReflectionProperty $property
     *
     * @return \FivePercent\Component\Converter\Converters\Money\MoneyConverterMetadata
     */
    public function loadMetadata(\ReflectionProperty $property);
}
