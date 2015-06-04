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

use Doctrine\Common\Annotations\Reader;
use FivePercent\Component\Converter\Annotation\DateTime;
use FivePercent\Component\Converter\Converters\DateTime\DateTimeConverterMetadata;
use FivePercent\Component\Converter\Converters\DateTime\Exception\DateTimeAnnotationNotFoundException;

/**
 * Annotation reader
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DateTimePropertyConverterAnnotationReader implements DateTimePropertyConverterReaderInterface
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
            $this->loadMetadata($property);

            return true;
        } catch (DateTimeAnnotationNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}}
     */
    public function loadMetadata(\ReflectionProperty $property)
    {
        $converterAnnotation = $this->getConverterAnnotation($property);

        return new DateTimeConverterMetadata(null, $converterAnnotation->format, $converterAnnotation->timezone);
    }

    /**
     * Get converter annotation
     *
     * @param \ReflectionProperty $property
     *
     * @return DateTime
     *
     * @throws DateTimeAnnotationNotFoundException
     */
    private function getConverterAnnotation(\ReflectionProperty $property)
    {
        $annotations = $this->reader->getPropertyAnnotations($property);

        $dateTimeAnnotation = null;

        foreach ($annotations as $annotation) {
            if ($annotation instanceof DateTime) {
                if ($dateTimeAnnotation) {
                    throw new \RuntimeException(sprintf(
                        'Many DateTime annotation in property %s->%s',
                        $property->getDeclaringClass()->getName(),
                        $property->getName()
                    ));
                }

                $dateTimeAnnotation = $annotation;
            }
        }

        if ($dateTimeAnnotation) {
            return $dateTimeAnnotation;
        }

        throw new DateTimeAnnotationNotFoundException(sprintf(
            'Not found DateTime annotation in property %s->%s',
            $property->getDeclaringClass()->getName(),
            $property->getName()
        ));
    }
}
