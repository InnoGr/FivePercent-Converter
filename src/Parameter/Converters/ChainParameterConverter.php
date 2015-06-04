<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter\Converters;

use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\Converter\Exception\ConverterNotFoundException;
use FivePercent\Component\Converter\Parameter\ParameterConverterInterface;

/**
 * Chain parameter converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ChainParameterConverter implements ParameterConverterInterface
{
    /**
     * @var array|ParameterConverterInterface[]
     */
    private $converters = array();

    /**
     * Add converter
     *
     * @param ParameterConverterInterface $converter
     *
     * @return ChainParameterConverter
     */
    public function addConverter(ParameterConverterInterface $converter)
    {
        $this->converters[spl_object_hash($converter)] = $converter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        foreach ($this->converters as $converter) {
            if (true === $converter->isSupported($parameter, $method)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(
        \ReflectionParameter $parameter,
        \ReflectionFunctionAbstract $method,
        $value,
        array $attributes = []
    ) {
        foreach ($this->converters as $converter) {
            if (true === $converter->isSupported($parameter, $method)) {
                return $converter->convert($parameter, $method, $value, $attributes);
            }
        }

        throw new ConverterNotFoundException(sprintf(
            'Not found parameter converter for argument "%s" in function "%s".',
            $parameter->getName(),
            Reflection::getCalledMethod($method)
        ));
    }
}
