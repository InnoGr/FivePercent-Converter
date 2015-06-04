<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\Money;

use FivePercent\Component\Converter\Converters\Money\MoneyConverter;
use FivePercent\Component\Converter\Property\PropertyConverterInterface;

/**
 * Money converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class MoneyPropertyConverter extends MoneyConverter implements PropertyConverterInterface
{
    /**
     * @var MoneyPropertyConverterReaderInterface
     */
    private $reader;

    /**
     * Construct
     *
     * @param MoneyPropertyConverterReaderInterface $reader
     */
    public function __construct(MoneyPropertyConverterReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionProperty $property)
    {
        return $this->reader->isSupported($property);
    }

    /**
     * {@inheritDoc}
     */
    public function convert(\ReflectionProperty $property, $value)
    {
        $metadata = $this->reader->loadMetadata($property);

        return $this->convertValue($metadata, $value);
    }
}
