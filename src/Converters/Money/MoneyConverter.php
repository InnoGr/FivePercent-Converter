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
 * Money converter helper.
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
abstract class MoneyConverter
{
    /**
     * Convert value
     *
     * @param MoneyConverterMetadata $metadata
     * @param float|integer|string   $value
     *
     * @return \FivePercent\Component\Money\Money
     */
    protected function convertValue(MoneyConverterMetadata $metadata, $value)
    {
        $callable = ['FivePercent\Component\Money\Money', $metadata->getFactoryMethod()];

        return call_user_func($callable, $value);
    }
}
