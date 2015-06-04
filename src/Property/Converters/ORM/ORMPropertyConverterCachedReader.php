<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Property\Converters\ORM;

use FivePercent\Component\Cache\CacheInterface;
use FivePercent\Component\Converter\Util\KeyGenerator;

/**
 * Cached reader for ORM property converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMPropertyConverterCachedReader implements ORMPropertyConverterReaderInterface
{
    /**
     * @var ORMPropertyConverterReaderInterface
     */
    private $delegate;

    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * Construct
     *
     * @param ORMPropertyConverterReaderInterface $delegate
     * @param CacheInterface                      $cache
     */
    public function __construct(ORMPropertyConverterReaderInterface $delegate, CacheInterface $cache)
    {
        $this->delegate = $delegate;
        $this->cache = $cache;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionProperty $property)
    {
        $cacheKey = 'property.converter.orm.parameters';

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
        $key = 'property.converter.orm.metadata:';
        $key .= KeyGenerator::generateForProperty($property);

        $metadata = $this->cache->get($key);

        if (null === $metadata) {
            $metadata = $this->delegate->loadMetadata($property);
            $this->cache->set($key, $metadata);
        }

        return $metadata;
    }
}
