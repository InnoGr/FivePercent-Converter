<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Util;

/**
 * Key generator for generate keys for caching
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class KeyGenerator
{
    /**
     * Generate key for parameter
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     *
     * @return string
     */
    public static function generateForParameter(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        if ($method instanceof \ReflectionMethod) {
            $key = $method->getDeclaringClass()->getName() . '::' . $method->getName() . ':' . $parameter->getName();
        } else {
            $key = 'function::'  . $method->getName() . ':' . $parameter->getName();
        }

        return $key;
    }

    /**
     * Generate key for property
     *
     * @param \ReflectionProperty $property
     *
     * @return string
     */
    public static function generateForProperty(\ReflectionProperty $property)
    {
        $key = $property->getDeclaringClass()->getName() . '::$' . $property->getName();

        return $key;
    }
}
