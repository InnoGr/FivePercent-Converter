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

use Doctrine\Common\Annotations\Reader;
use FivePercent\Component\Converter\Annotation\ORM;
use FivePercent\Component\Converter\Converters\ORM\Exception\ORMAnnotationNotFoundException;
use FivePercent\Component\Converter\Converters\ORM\ORMConverterMetadata;

/**
 * Annotation reader for ORM property converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMPropertyConverterAnnotationReader implements ORMPropertyConverterReaderInterface
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
     * Is property supported
     *
     * @param \ReflectionProperty $property
     *
     * @return bool
     */
    public function isSupported(\ReflectionProperty $property)
    {
        try {
            $this->getConverterAnnotation($property);

            return true;
        } catch (ORMAnnotationNotFoundException $e) {
            return false;
        }
    }

    /**
     * Load metadata
     *
     * @param \ReflectionProperty $property
     *
     * @return ORMConverterMetadata
     *
     * @throws \RuntimeException
     */
    public function loadMetadata(\ReflectionProperty $property)
    {
        $convertAnnotation = $this->getConverterAnnotation($property);

        $findMethod = $convertAnnotation->findMethod;

        if (!$findMethod) {
            if ($convertAnnotation->collection) {
                $findMethod = 'findBy';
            } else {
                $findMethod = 'findOneBy';
            }
        }

        if (!$convertAnnotation->entityClass) {
            throw new \RuntimeException(sprintf(
                'The attribute "entityClass" in annotation @ORM must be a specified in property %s->%s.',
                $property->getDeclaringClass()->getName(),
                $property->getName()
            ));
        }

        $metadata = new ORMConverterMetadata(
            $convertAnnotation->entityClass,
            $convertAnnotation->repositoryClass,
            $findMethod,
            $convertAnnotation->findPropertyName,
            $convertAnnotation->value,
            $convertAnnotation->findExtraParameters,
            $convertAnnotation->exceptionIfNotFound,
            $convertAnnotation->exceptionMessage,
            $convertAnnotation->exceptionCode,
            $convertAnnotation->collection
        );

        return $metadata;

    }

    /**
     * Get converter annotation
     *
     * @param \ReflectionProperty $property
     *
     * @return ORM
     *
     * @throws ORMAnnotationNotFoundException
     */
    private function getConverterAnnotation(\ReflectionProperty $property)
    {
        $annotations = $this->reader->getPropertyAnnotations($property);

        $ormAnnotation = null;

        foreach ($annotations as $annotation) {
            if ($annotation instanceof ORM) {
                if ($ormAnnotation) {
                    throw new \RuntimeException(sprintf(
                        'Many ORM annotation in property %s->%s',
                        $property->getDeclaringClass()->getName(),
                        $property->getName()
                    ));
                }

                $ormAnnotation = $annotation;
            }
        }

        if ($ormAnnotation) {
            return $ormAnnotation;
        }

        throw new ORMAnnotationNotFoundException(sprintf(
            'Not found ORM annotation in property %s->%s',
            $property->getDeclaringClass()->getName(),
            $property->getName()
        ));
    }
}
