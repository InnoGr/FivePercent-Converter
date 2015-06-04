<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter\Converters\ORM;

use Doctrine\Common\Annotations\Reader;
use FivePercent\Component\Reflection\Reflection;
use FivePercent\Component\Converter\Annotation\ORM;
use FivePercent\Component\Converter\Converters\ORM\Exception\ORMAnnotationNotFoundException;
use FivePercent\Component\Converter\Converters\ORM\ORMConverterMetadata;

/**
 * ORM parameter converter reader
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMParameterConverterAnnotationReader implements ORMParameterConverterReaderInterface
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
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        if (!$method instanceof \ReflectionMethod) {
            // Only method supported
            return false;
        }

        try {
            $this->getConverterAnnotation($parameter, $method);

            return true;
        } catch (ORMAnnotationNotFoundException $e) {
            return false;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        if (!$method instanceof \ReflectionMethod) {
            throw new \RuntimeException(
                'Only method supported for convert ORM parameter, but function given.'
            );
        }

        $convertAnnotation = $this->getConverterAnnotation($parameter, $method);

        if (!$convertAnnotation) {
            throw new \RuntimeException(sprintf(
                'Not found convert annotation in method "%s" for parameter "%s".',
                Reflection::getCalledMethod($method),
                $parameter->getName()
            ));
        }

        $findMethod = $convertAnnotation->findMethod;

        if (!$findMethod) {
            if ($convertAnnotation->collection) {
                $findMethod = 'findBy';
            } else {
                $findMethod = 'findOneBy';
            }
        }

        $entityClass = $convertAnnotation->entityClass;

        if (!$entityClass) {
            $entityClass = $parameter->getClass()->getName();
        }

        if (!$entityClass) {
            throw new \RuntimeException(sprintf(
                'Cannot not get entity class for parameter "%s" in method "%s".',
                $parameter->getName(),
                Reflection::getCalledMethod($method)
            ));
        }

        $metadata = new ORMConverterMetadata(
            $entityClass,
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
     * @param \ReflectionParameter $parameter
     * @param \ReflectionMethod    $method
     *
     * @return ORM
     *
     * @throws ORMAnnotationNotFoundException
     */
    private function getConverterAnnotation(\ReflectionParameter $parameter, \ReflectionMethod $method)
    {
        $annotations = $this->reader->getMethodAnnotations($method);

        foreach ($annotations as $annotation) {
            if ($annotation instanceof ORM) {
                // Check parameter name
                if ($annotation->name === $parameter->name) {
                    return $annotation;
                }

                // Check classes
                if ($class = $parameter->getClass()) {
                    if (is_a($class->getName(), $annotation->entityClass, true)) {
                        return $annotation;
                    }
                }

                if (!$annotation->name && !$annotation->entityClass) {
                    throw new \RuntimeException(sprintf(
                        'Invalid @ORM annotation. The name or entity class must be specified in method "%s".',
                        Reflection::getCalledMethod($method)
                    ));
                }
            }
        }

        throw new ORMAnnotationNotFoundException(sprintf(
            'Not found ORM annotation for parameter "%s" in method "%s".',
            $parameter->getName(),
            Reflection::getCalledMethod($method)
        ));
    }
}
