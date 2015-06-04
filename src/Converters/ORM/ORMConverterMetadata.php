<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Converters\ORM;

/**
 * Metadata for convert ORM parameters
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMConverterMetadata
{
    /**
     * Parameter name
     *
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var string
     */
    protected $repositoryClass;

    /**
     * @var string
     */
    protected $findMethod;

    /**
     * @var string
     */
    protected $value;

    /**
     * @var string
     */
    protected $findPropertyName;

    /**
     * @var array
     */
    protected $findExtraParameters;

    /**
     * @var string
     */
    protected $exceptionIfNotFound;

    /**
     * @var string
     */
    protected $exceptionMessage;

    /**
     * @var int
     */
    protected $exceptionCode;

    /**
     * @var bool
     */
    protected $collection;

    /**
     * Construct
     *
     * @param string $entityClass
     * @param string $repositoryClass
     * @param string $findMethod
     * @param string $findPropertyName
     * @param string $value
     * @param array $findExtraParameters
     * @param string $exceptionIfNotFound
     * @param string $exceptionMessage
     * @param int $exceptionCode
     * @param bool $collection
     */
    public function __construct(
        $entityClass,
        $repositoryClass,
        $findMethod,
        $findPropertyName,
        $value,
        array $findExtraParameters,
        $exceptionIfNotFound,
        $exceptionMessage,
        $exceptionCode,
        $collection
    ) {
        $this->entityClass = $entityClass;
        $this->repositoryClass = $repositoryClass;
        $this->findMethod = $findMethod;
        $this->findPropertyName = $findPropertyName;
        $this->value = $value;
        $this->findExtraParameters = $findExtraParameters;
        $this->exceptionIfNotFound = $exceptionIfNotFound;
        $this->exceptionMessage = $exceptionMessage;
        $this->exceptionCode = $exceptionCode;
        $this->collection = $collection;
    }

    /**
     * Get entity class
     *
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * Get find method
     *
     * @return string
     */
    public function getFindMethod()
    {
        return $this->findMethod;
    }

    /**
     * Get find property name
     *
     * @return string
     */
    public function getFindPropertyName()
    {
        return $this->findPropertyName;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Get find extra parameters
     *
     * @return array
     */
    public function getFindExtraParameters()
    {
        return $this->findExtraParameters;
    }

    /**
     * Get exception if not found
     *
     * @return string
     */
    public function getExceptionIfNotFound()
    {
        return $this->exceptionIfNotFound;
    }

    /**
     * Get exception message
     *
     * @return string
     */
    public function getExceptionMessage()
    {
        return $this->exceptionMessage;
    }

    /**
     * Get exception code
     *
     * @return int
     */
    public function getExceptionCode()
    {
        return $this->exceptionCode;
    }

    /**
     * Is collection
     *
     * @return bool
     */
    public function isCollection()
    {
        return $this->collection;
    }

    /**
     * @return string
     */
    public function getRepositoryClass()
    {
        return $this->repositoryClass;
    }
}
