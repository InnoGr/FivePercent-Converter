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
 * All converter managers should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface ParameterConverterManagerInterface
{
    const GROUP_DEFAULT = 'default';

    /**
     * Set converter by group
     *
     * @param ParameterConverterInterface $converter
     * @param string             $group
     */
    public function setConverter(ParameterConverterInterface $converter, $group);

    /**
     * Get converter by group
     *
     * @param string $group
     *
     * @return ParameterConverterInterface
     */
    public function getConverter($group);

    /**
     * Is has converter for group
     *
     * @param string $group
     *
     * @return bool
     */
    public function hasConverter($group);

    /**
     * Convert parameter
     *
     * @param \ReflectionParameter        $parameter
     * @param \ReflectionFunctionAbstract $method
     * @param mixed                       $value
     * @param string                      $group
     * @param array                       $attributes
     *
     * @return mixed
     *
     * @throws \FivePercent\Component\Converter\Exception\ConverterNotSupportedException
     */
    public function convertParameter(
        \ReflectionParameter $parameter,
        \ReflectionFunctionAbstract $method,
        $value,
        $group,
        array $attributes = []
    );

    /**
     * Convert arguments for method or function
     *
     * @param \ReflectionFunctionAbstract $method
     * @param array                       $values
     * @param string                      $group
     * @param array                       $attributes
     *
     * @return array
     */
    public function convertArguments(
        \ReflectionFunctionAbstract $method,
        array $values,
        $group,
        array $attributes = []
    );
}
