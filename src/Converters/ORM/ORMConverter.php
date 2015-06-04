<?php

/**
 * This file is part of the Converter package
 *
 * (c) InnovationGroup
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FivePercent\Component\Converter\Converters\ORM;

use Doctrine\Common\Persistence\ManagerRegistry;
use FivePercent\Component\Converter\Exception\ConverterException;

/**
 * ORM converter
 *
 * @author Vitaliy Zhuk <zhuk2205@gmail.com>
 */
abstract class ORMConverter
{
    /**
     * @var ManagerRegistry
     */
    protected $managerRegistry;

    /**
     * Convert value with metadata
     *
     * @param ORMConverterMetadata $metadata
     * @param mixed                $value
     * @param bool                 $optional
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function convertValue(ORMConverterMetadata $metadata, $value, $optional)
    {
        if (!$value) {
            return null;
        }

        $repositoryClass = $metadata->getRepositoryClass() ?: $metadata->getEntityClass();
        $manager = $this->managerRegistry->getManagerForClass($repositoryClass);
        $repository = $manager->getRepository($repositoryClass);

        $callback = array($repository, $metadata->getFindMethod());
        $findMethod = $metadata->getFindMethod();

        if (!is_callable($callback)) {
            throw new ConverterException(sprintf(
                'Not found method "%s" in repository "%s".',
                $metadata->getFindMethod(),
                get_class($repository)
            ));
        }

        if (is_array($value)) {
            $callArguments = $value;
        } else {
            $callArguments = array(
                $metadata->getFindPropertyName() => $value
            );
        }

        $callArguments += $metadata->getFindExtraParameters();

        if ($findMethod === 'findBy' || $findMethod === 'findOneBy') {
            $converterValue = call_user_func_array($callback, [$callArguments]);
        } else {
            $converterValue = call_user_func_array($callback, $callArguments);
        }

        if ($metadata->isCollection() && (!$converterValue instanceof \Traversable && !is_array($converterValue))) {
            throw new ConverterException(sprintf(
                'The find method "%s" should be return \Traversable instance, but "%s" given.',
                $findMethod,
                is_object($converterValue) ? get_class($converterValue) : gettype($converterValue)
            ));
        }

        if (!$converterValue && !$optional && $metadata->getExceptionIfNotFound()) {
            $exceptionClass = $metadata->getExceptionIfNotFound();

            $replacedArguments = array();
            foreach ($callArguments as $callArgumentName => $callArgumentValue) {
                $replacedArguments[':' . $callArgumentName] = $callArgumentValue;
            }

            $exceptionMessage = $metadata->getExceptionMessage();
            $exceptionMessage = strtr($exceptionMessage, $replacedArguments);

            $exception = new $exceptionClass($exceptionMessage, $metadata->getExceptionCode());

            throw $exception;
        }

        return $converterValue;
    }
}
