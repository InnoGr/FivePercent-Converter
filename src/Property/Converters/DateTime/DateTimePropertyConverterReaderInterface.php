<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\DateTime;

/**
 * All datetime readers should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface DateTimePropertyConverterReaderInterface
{
    /**
     * Is supported
     *
     * @param \ReflectionProperty $property
     */
    public function isSupported(\ReflectionProperty $property);

    /**
     * Load metadata
     *
     * @param \ReflectionProperty $property
     *
     * @return \FivePercent\Component\Converter\Converters\DateTime\DateTimeConverterMetadata
     */
    public function loadMetadata(\ReflectionProperty $property);
}
