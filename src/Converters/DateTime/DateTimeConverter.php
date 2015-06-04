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

use FivePercent\Component\Converter\Converters\ORM\Exception\InvalidArgumentException;

/**
 * Datetime converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
abstract class DateTimeConverter
{
    /**
     * Convert value
     *
     * @param DateTimeConverterMetadata $metadata
     * @param string           $value
     *
     * @return \DateTime
     */
    protected function convertValue(DateTimeConverterMetadata $metadata, $value)
    {
        if (!$value) {
            return null;
        }

        $format = $metadata->getFormat();

        $timezone = $metadata->getTimezone()
            ? new \DateTimeZone($metadata->getTimezone())
            : new \DateTimeZone(date_default_timezone_get());

        $datetime = null;
        if ($value == 'now') {
            $datetime = new \DateTime($value, $timezone);
        } else {
            $datetime = \DateTime::createFromFormat($format, $value, $timezone);
        }

        if (false === $datetime) {
            // Get latest datetime errors
            $errors = \DateTime::getLastErrors();

            if (count($errors['errors'])) {
                $errorString = implode('. ', array_unique($errors['errors'])) . '.';

                throw new InvalidArgumentException($errorString);
            }
        }

        return $datetime;
    }
}
