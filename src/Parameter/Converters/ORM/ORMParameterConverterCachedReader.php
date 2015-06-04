<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter\Converters\ORM;

use FivePercent\Component\Cache\CacheInterface;
use FivePercent\Component\Converter\Util\KeyGenerator;

/**
 * Cached reader for ORM Parameter converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMParameterConverterCachedReader implements ORMParameterConverterReaderInterface
{
    /**
     * @var CacheInterface
     */
    private $cache;

    /**
     * @var ORMParameterConverterReaderInterface
     */
    private $delegate;

    /**
     * Construct
     *
     * @param ORMParameterConverterReaderInterface $delegate
     * @param CacheInterface                       $cache
     */
    public function __construct(ORMParameterConverterReaderInterface $delegate, CacheInterface $cache)
    {
        $this->cache = $cache;
        $this->delegate = $delegate;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        $cacheKey = 'parameter.converter.orm.parameters';

        $key = KeyGenerator::generateForParameter($parameter, $method);

        $parameters = $this->cache->get($cacheKey);

        if (null === $parameters) {
            $parameters = [];
        }

        if (!isset($parameters[$key])) {
            $supports = $this->delegate->isSupported($parameter, $method);
            $parameters[$key] = $supports;
            $mustUpdateCache = true;
        } else {
            $supports = $parameters[$key];
            $mustUpdateCache = false;
        }

        if ($mustUpdateCache) {
            $this->cache->set($cacheKey, $parameters);
        }

        return $supports;
    }

    /**
     * {@inheritDoc}
     */
    public function loadMetadata(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        $key = 'parameter.converter.orm.metadata:';
        $key .= KeyGenerator::generateForParameter($parameter, $method);

        $metadata = $this->cache->get($key);

        if (null === $metadata) {
            $metadata = $this->delegate->loadMetadata($parameter, $method);
            $this->cache->set($key, $metadata);
        }

        return $metadata;
    }
}
