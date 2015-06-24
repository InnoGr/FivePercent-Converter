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

use Doctrine\Common\Persistence\ManagerRegistry;
use FivePercent\Component\Converter\Converters\ORM\ORMConverter;
use FivePercent\Component\Converter\Parameter\ParameterConverterInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

/**
 * Converter values for entities
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
class ORMParameterConverter extends ORMConverter implements ParameterConverterInterface
{
    /**
     * @var ORMParameterConverterReaderInterface
     */
    private $reader;

    /**
     * @var ExpressionLanguage
     */
    private $expressionLanguage;

    /**
     * Construct
     *
     * @param ManagerRegistry                       $managerRegistry
     * @param ORMParameterConverterReaderInterface  $reader
     * @param ExpressionLanguage                    $expressionLanguage
     */
    public function __construct(
        ManagerRegistry $managerRegistry,
        ORMParameterConverterReaderInterface $reader,
        ExpressionLanguage $expressionLanguage = null
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->reader = $reader;
        $this->expressionLanguage = $expressionLanguage;
    }

    /**
     * {@inheritDoc}
     */
    public function isSupported(\ReflectionParameter $parameter, \ReflectionFunctionAbstract $method)
    {
        return $this->reader->isSupported($parameter, $method);
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
        $metadata = $this->reader->loadMetadata($parameter, $method);

        if (!$value && $metadata->getValue()) {
            $value = $metadata->getValue();

            if (is_array($value)) {
                foreach ($value as $key => $childValue) {
                    $value[$key] = $this->evaluateValue($childValue, $attributes);
                }
            } else {
                $value = $this->evaluateValue($value, $attributes);
            }
        }

        return $this->convertValue($metadata, $value, false);
    }

    /**
     * Evaluate value
     *
     * @param string $value
     * @param array  $attributes
     *
     * @return mixed
     */
    private function evaluateValue($value, array $attributes)
    {
        if ($value[0] == '@') {
            if (!$this->expressionLanguage) {
                throw new \LogicException(
                    'Can not evaluate expression language. Please inject ExpressionLanguage to ORMParameterConverter.'
                );
            }

            $value = substr($value, 1);
            $value = $this->expressionLanguage->evaluate($value, $attributes);
        }

        return $value;
    }
}
