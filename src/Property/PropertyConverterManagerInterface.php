<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property;

/**
 * All property converter managers should be implemented of this interface
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
interface PropertyConverterManagerInterface
{
    const GROUP_DEFAULT = 'default';

    /**
     * Add converter for group
     *
     * @param PropertyConverterInterface $converter
     * @param string             $group
     */
    public function setConverter(PropertyConverterInterface $converter, $group);

    /**
     * Get converter for group
     *
     * @param string $group
     *
     * @return PropertyConverterInterface
     *
     * @throws \FivePercent\Component\Converter\Exception\ConverterNotFoundException
     */
    public function getConverter($group);

    /**
     * Has converter
     *
     * @param string $group
     *
     * @return bool
     */
    public function hasConverter($group);

    /**
     * Convert value of property
     *
     * @param object $object
     * @param string $name
     * @param string $group
     */
    public function convertProperty($object, $name, $group);

    /**
     * Convert properties in object
     *
     * @param object $object
     * @param string $group
     */
    public function convertProperties($object, $group);
}
