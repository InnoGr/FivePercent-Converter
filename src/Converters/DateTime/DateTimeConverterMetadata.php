<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Converters\DateTime;

/**
 * DateTime converter metadata
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DateTimeConverterMetadata
{
    /**
     * Parameter name. Used only for method parameter.
     *
     * @var string
     */
    private $name;

    /**
     * Input date time format
     *
     * @var string
     */
    private $format;

    /**
     * @var string
     */
    private $timezone;

    /**
     * Construct
     *
     * @param string $name
     * @param string $format
     * @param string $timezone
     */
    public function __construct($name, $format, $timezone)
    {
        $this->name = $name;
        $this->format = $format;
        $this->timezone = $timezone;
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
     * Get format
     *
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Get timezone
     *
     * @return string
     */
    public function getTimezone()
    {
        return $this->timezone;
    }
}
