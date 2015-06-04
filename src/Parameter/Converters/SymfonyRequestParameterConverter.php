<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Parameter\Converters;

use FivePercent\Component\Converter\Exception\ConverterException;
use FivePercent\Component\Converter\Parameter\ParameterConverterInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Symfony2 Request parameter converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class SymfonyRequestParameterConverter implements ParameterConverterInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * Construct
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        if (!$this->container->isScopeActive('request')) {
            return false;
        }

        if (!$this->container->has('request')) {
            return false;
        }

        if ($class = $parameter->getClass()) {
            return is_a($class->getName(), 'Symfony\Component\HttpFoundation\Request', true);
        }

        return false;
    }

    /**
     * {@inheritDoc}
     */
    public function convert(
        \ReflectionParameter $parameter,
        \ReflectionFunctionAbstract $method,
        $value,
        array $attributes = []
    ) {
        if (!$this->container->isScopeActive('request') || !$this->container->has('request')) {
            throw new ConverterException(
                'Could not convert Request parameter in not active "request" scope.'
            );
        }

        return $this->container->get('request');
    }
}
