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
 * Indicate of DateTime converter
 *
 * @Annotation()
 * @Target({"METHOD", "PROPERTY"})
 *
 * Attention: Formats have a "+" char, but in URI this char encoding to "%2B". And another special chars.
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DateTime
{
    /**
     * Used only for method parameter converter
     *
     * @var string
     */
    public $name;

    /**
     * Input datetime format
     *
     * @var string
     */
    public $format = \DateTime::ISO8601;

    /**
     * Timezone
     *
     * @var string|null
     */
    public $timezone;
}
