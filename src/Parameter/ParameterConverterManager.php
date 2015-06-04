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

use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\Converter\Exception\ConverterNotFoundException;
use FivePercent\Component\Converter\Exception\ConverterNotSupportedException;

/**
 * Parameter converter manager
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ParameterConverterManager implements ParameterConverterManagerInterface
{
    /**
     * @var array|ParameterConverterInterface[]
     */
    private $groups = array();

    /**
     * {@inheritDoc}
     */
    public function setConverter(ParameterConverterInterface $converter, $group)
    {
        $this->groups[$group] = $converter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getConverter($group)
    {
        if (!isset($this->groups[$group])) {
            throw new ConverterNotFoundException(sprintf(
                'Not found parameter converter for group "%s".',
                $group
            ));
        }

        return $this->groups[$group];
    }

    /**
     * {@inheritDoc}
     */
    public function hasConverter($group)
    {
        return isset($this->groups[$group]);
    }

    /**
     * {@inheritDoc}
     */
    public function convertParameter(
        \ReflectionParameter $parameter,
        \ReflectionFunctionAbstract $method,
        $value,
        $group,
        array $attributes = []
    ) {
        $converter = $this->getConverter($group);

        if (!$converter->isSupported($parameter, $method)) {
            throw new ConverterNotSupportedException(sprintf(
                'The parameter converter "%s" not supported in function "%s".',
                $parameter->getName(),
                Reflection::getCalledMethod($method)
            ));
        }

        $value = $converter->convert($parameter, $method, $value, $attributes);

        return $value;
    }

    /**
     * {@inheritDoc}
     */
    public function convertArguments(\ReflectionFunctionAbstract $method, array $values, $group, array $attributes = [])
    {
        $parameters = $method->getParameters();
        $arguments = array();
        $converter = $this->getConverter($group);

        foreach ($parameters as $parameter) {
            $value = isset($values[$parameter->getName()]) ? $values[$parameter->getName()] : null;

            if ($converter->isSupported($parameter, $method)) {
                $attributes['arguments'] = $values;
                $convertedValue = $converter->convert($parameter, $method, $value, $attributes);
            } else {
                // @todo: check correct get default value!
                if ($parameter->isOptional()) {
                    $convertedValue = $parameter->getDefaultValue();
                } else {
                    $convertedValue = $value;
                }
            }

            $arguments[$parameter->getName()] = $convertedValue;
        }

        return $arguments;
    }
}
