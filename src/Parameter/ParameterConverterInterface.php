<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter;

/**
 * All parameter converters should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ParameterConverterInterface
{
    /**
     * Is parameter supported
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     *
     * @return bool
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method);

    /**
     * Convert value
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     * @param mixed                       $value
     * @param array                       $attributes
     *
     * @return mixed
     */
    public function convert(
        \ReflectionParameter $parameter,
        \ReflectionFunctionAbstract $method,
        $value,
        array $attributes = []
    );
}
