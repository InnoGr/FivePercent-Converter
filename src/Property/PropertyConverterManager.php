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

use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\Converter\Converters\ORM\Exception\InvalidArgumentException;
use FivePercent\Component\Converter\Exception\ConverterNotFoundException;
use FivePercent\Component\Exception\UnexpectedTypeException;

/**
 * Base converter manager
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class PropertyConverterManager implements PropertyConverterManagerInterface
{
    /**
     * @var array|PropertyConverterInterface[]
     */
    private $converters;

    /**
     * {@inheritDoc}
     */
    public function setConverter(PropertyConverterInterface $converter, $group)
    {
        $this->converters[$group] = $converter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getConverter($group)
    {
        if (isset($this->converters[$group])) {
            return $this->converters[$group];
        }

        throw new ConverterNotFoundException(sprintf(
            'Not found property converter for group "%s".',
            $group
        ));
    }

    /**
     * {@inheritDoc}
     */
    public function hasConverter($group)
    {
        return isset($this->converters[$group]);
    }

    /**
     * {@inheritDoc}
     */
    public function convertProperty($object, $name, $group)
    {
        if (!is_object($object)) {
            throw UnexpectedTypeException::create($object, 'object');
        }

        $classReflection = Reflection::loadClassReflection($object);
        $property = $classReflection->getProperty($name);

        $this->convertPropertyReflection($object, $property, $group);
    }

    /**
     * {@inheritDoc}
     */
    public function convertProperties($object, $group)
    {
        if (!is_object($object)) {
            throw UnexpectedTypeException::create($object, 'object');
        }

        $converter = $this->getConverter($group);

        $classReflection = Reflection::loadClassReflection($object);
        $properties = $classReflection->getProperties();

        foreach ($properties as $property) {
            if ($converter->isSupported($property)) {
                $this->convertPropertyReflection($object, $property, $group);
            }
        }
    }

    /**
     * Convert for reflection property
     *
     * @param object              $object
     * @param \ReflectionProperty $property
     * @param string              $group
     */
    private function convertPropertyReflection($object, \ReflectionProperty $property, $group)
    {
        $converter = $this->getConverter($group);

        if (!$property->isPublic()) {
            $property->setAccessible(true);
        }

        $value = $property->getValue($object);

        try {
            $converterValue = $converter->convert($property, $value);
        } catch (InvalidArgumentException $e) {
            $e->setName($property->getName());
            $e->setInvalidValue($value);

            throw $e;
        }

        $property->setValue($object, $converterValue);
    }
}
