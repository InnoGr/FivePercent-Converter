<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters;

use FivePercent\Component\Converter\Exception\ConverterNotFoundException;
use FivePercent\Component\Converter\Property\PropertyConverterInterface;

/**
 * Chain parameter converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ChainPropertyConverter implements PropertyConverterInterface
{
    /**
     * @var array|PropertyConverterInterface[]
     */
    private $converters = array();

    /**
     * Add converter
     *
     * @param PropertyConverterInterface $converter
     *
     * @return ChainPropertyConverter
     */
    public function addConverter(PropertyConverterInterface $converter)
    {
        $this->converters[spl_object_hash($converter)] = $converter;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionProperty $property)
    {
        foreach ($this->converters as $converter) {
            if (true === $converter->isSupported($property)) {
                return true;
            }
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(\ReflectionProperty $property, $value)
    {
        foreach ($this->converters as $converter) {
            if (true === $converter->isSupported($property)) {
                return $converter->convert($property, $value);
            }
        }

        throw new ConverterNotFoundException(sprintf(
            'Not found property converter for property "%s" in object of class "%s".',
            $property->getName(),
            $property->getDeclaringClass()->getName()
        ));
    }
}
