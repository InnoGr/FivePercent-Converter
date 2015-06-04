<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Annotation;

/**
 * Indicate of ORM parameter converter
 *
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORM
{
    /** @var string */
    public $name;
    /** @var string */
    public $entityClass;
    /** @var string */
    public $repositoryClass;
    /** @var string */
    public $findMethod;
    /** @var string */
    public $findPropertyName = 'id';
    /** @var mixed */
    public $value = null;
    /** @var array */
    public $findExtraParameters = [];
    /** @var string */
    public $exceptionIfNotFound = 'InvalidArgumentException';
    /** @var string */
    public $exceptionMessage = 'Not found entity with identifier ":id".';
    /** @va int */
    public $exceptionCode = 0;
    /** @var bool */
    public $collection = false;
}
