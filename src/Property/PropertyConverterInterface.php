<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property;

/**
 * All property converters should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface PropertyConverterInterface
{
    /**
     * Is supported
     *
     * @param \ReflectionProperty $property
     */
    public function isSupported(\ReflectionProperty $property);

    /**
     * Convert value
     *
     * @param \ReflectionProperty $property
     * @param mixed               $value
     *
     * @return mixed
     */
    public function convert(\ReflectionProperty $property, $value);
}
