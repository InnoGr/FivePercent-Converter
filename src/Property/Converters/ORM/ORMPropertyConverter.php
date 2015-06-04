<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\ORM;

use Doctrine\Common\Persistence\ManagerRegistry;
use FivePercent\Component\Converter\Converters\ORM\ORMConverter;
use FivePercent\Component\Converter\Property\PropertyConverterInterface;

/**
 * ORM property converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMPropertyConverter extends ORMConverter implements PropertyConverterInterface
{
    /**
     * @var ORMPropertyConverterReaderInterface
     */
    private $reader;

    /**
     * Construct
     *
     * @param ManagerRegistry                     $managerRegistry
     * @param ORMPropertyConverterReaderInterface $reader
     */
    public function __construct(ManagerRegistry $managerRegistry, ORMPropertyConverterReaderInterface $reader)
    {
        $this->managerRegistry = $managerRegistry;
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

        return $this->convertValue($metadata, $value, false);
    }
}
