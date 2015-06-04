<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\DateTime;

use FivePercent\Component\Cache\CacheInterface;
use FivePercent\Component\Converter\Util\KeyGenerator;

/**
 * Cached reader for datetime property converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class DateTimePropertyConverterCachedReader implements DateTimePropertyConverterReaderInterface
{
    /**
     * @var DateTimePropertyConverterReaderInterface
     */
    private $delegate;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Construct
     *
     * @param DateTimePropertyConverterReaderInterface $delegate
     * @param CacheInterface                           $cache
     */
    public function __construct(DateTimePropertyConverterReaderInterface $delegate, CacheInterface $cache)
    {
        $this->delegate = $delegate;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionProperty $property)
    {
        $cacheKey = 'property.converter.datetime.parameters';

        $key = KeyGenerator::generateForProperty($property);

        $properties = $this->cache->get($cacheKey);

        if (null === $properties) {
            $properties = [];
        }

        if (!isset($properties[$key])) {
            $supports = $this->delegate->isSupported($property);
            $properties[$key] = $supports;
            $mustUpdateCache = true;
        } else {
            $supports = $properties[$key];
            $mustUpdateCache = false;
        }

        if ($mustUpdateCache) {
            $this->cache->set($cacheKey, $properties);
        }

        return $supports;
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata(\ReflectionProperty $property)
    {
        $key = 'property.converter.datetime.metadata:';
        $key .= KeyGenerator::generateForProperty($property);

        $metadata = $this->cache->get($key);

        if (null === $metadata) {
            $metadata = $this->delegate->loadMetadata($property);
            $this->cache->set($key, $metadata);
        }

        return $metadata;
    }
}
