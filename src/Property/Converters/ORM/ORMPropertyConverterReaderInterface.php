<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\ORM;

/**
 * All readers for ORM property converter should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ORMPropertyConverterReaderInterface
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
     * @return \FivePercent\Component\Converter\Converters\ORM\ORMConverterMetadata
     */
    public function loadMetadata(\ReflectionProperty $property);
}
