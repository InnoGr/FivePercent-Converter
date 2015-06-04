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

use Doctrine\Common\Annotations\Reader;
use FivePercent\Component\Converter\Annotation\Money;
use FivePercent\Component\Converter\Converters\Money\Exception\MoneyAnnotationNotFoundException;
use FivePercent\Component\Converter\Converters\Money\MoneyConverterMetadata;

/**
 * Annotation reader for money converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class MoneyPropertyConverterAnnotationReader implements MoneyPropertyConverterReaderInterface
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * Construct
     *
     * @param Reader $reader
     */
    public function __construct(Reader $reader)
    {
        $this->reader = $reader;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionProperty $property)
    {
        try {
            $this->getConverterAnnotation($property);

            return true;
        } catch (MoneyAnnotationNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata(\ReflectionProperty $property)
    {
        $annotation = $this->getConverterAnnotation($property);

        return new MoneyConverterMetadata(null, $annotation->factoryMethod);
    }

    /**
     * Get converter annotation
     *
     * @param \ReflectionProperty $property
     *
     * @return Money
     *
     * @throws MoneyAnnotationNotFoundException
     */
    private function getConverterAnnotation(\ReflectionProperty $property)
    {
        $annotations = $this->reader->getPropertyAnnotations($property);

        $moneyAnnotation = null;

        foreach ($annotations as $annotation) {
            if ($annotation instanceof Money) {
                if ($moneyAnnotation) {
                    throw new \RuntimeException(sprintf(
                        'Many Money annotation in property %s->%s',
                        $property->getDeclaringClass()->getName(),
                        $property->getName()
                    ));
                }

                $moneyAnnotation = $annotation;
            }
        }

        if ($moneyAnnotation) {
            return $moneyAnnotation;
        }

        throw new MoneyAnnotationNotFoundException(sprintf(
            'Not found DateTime annotation in property %s->%s',
            $property->getDeclaringClass()->getName(),
            $property->getName()
        ));
    }
}
