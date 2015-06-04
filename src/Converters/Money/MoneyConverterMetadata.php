<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Converters\Money;

/**
 * Money converter metadata
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class MoneyConverterMetadata
{
    /**
     * Parameter name. Used only for method parameter.
     *
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $factoryMethod;

    /**
     * Construct
     *
     * @param string $name
     * @param string $factoryMethod
     */
    public function __construct($name, $factoryMethod)
    {
        $this->name = $name;
        $this->factoryMethod = $factoryMethod;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get factory method
     *
     * @return string
     */
    public function getFactoryMethod()
    {
        return $this->factoryMethod;
    }
}
