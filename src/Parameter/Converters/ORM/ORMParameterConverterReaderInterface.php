<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter\Converters\ORM;

/**
 * All readers for ORM parameter converter should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ORMParameterConverterReaderInterface
{
    /**
     * Is supported
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     *
     * @return bool
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method);

    /**
     * Get metadata for next converts
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     *
     * @return  \FivePercent\Component\Converter\Converters\ORM\ORMConverterMetadata
     */
    public function loadMetadata(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method);
}
