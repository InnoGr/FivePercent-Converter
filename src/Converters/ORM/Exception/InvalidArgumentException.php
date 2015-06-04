<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Converters\ORM\Exception;

/**
 * Invalid argument
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class InvalidArgumentException extends \InvalidArgumentException
{
    /**
     * The name method argument or parameter
     *
     * @var string
     */
    private $name;

    /**
     * Invalid value
     *
     * @var mixed
     */
    private $invalidValue;

    /**
     * Set name
     *
     * @param string $name
     *
     * @return InvalidArgumentException
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * Set invalid value
     *
     * @param mixed $invalidValue
     *
     * @return InvalidArgumentException
     */
    public function setInvalidValue($invalidValue)
    {
        $this->invalidValue = $invalidValue;

        return $this;
    }

    /**
     * Get invalid value
     *
     * @return mixed
     */
    public function getInvalidValue()
    {
        return $this->invalidValue;
    }
}
