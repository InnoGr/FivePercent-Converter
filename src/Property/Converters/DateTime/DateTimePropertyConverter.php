<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\DateTime;

use FivePercent\Component\Converter\Converters\DateTime\DateTimeConverter;
use FivePercent\Component\Converter\Property\PropertyConverterInterface;

/**
 * Date time property converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DateTimePropertyConverter extends DateTimeConverter implements PropertyConverterInterface
{
    /**
     * @var DateTimePropertyConverterReaderInterface
     */
    private $reader;

    /**
     * Construct
     *
     * @param DateTimePropertyConverterReaderInterface $reader
     */
    public function __construct(DateTimePropertyConverterReaderInterface $reader)
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
