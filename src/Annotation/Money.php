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
 * Indicate of money converter
 *
 * @Annotation
 * @Target({"METHOD", "PROPERTY"})
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class Money
{
    /**
     * Name of method parameter (Used only for parameter converter)
     *
     * @var string
     */
    public $name;

    /**
     * Method for create "Money" instance
     *
     * @var string
     *
     * @Enum({"create", "fromCents"})
     */
    public $factoryMethod = 'create';
}
