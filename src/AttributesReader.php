<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=0);

namespace ServiceBus\AnnotationsReader;

use ServiceBus\AnnotationsReader\Attribute\ClassLevel;
use ServiceBus\AnnotationsReader\Attribute\MethodLevel;
use ServiceBus\AnnotationsReader\Exceptions\ParseAttributesFailed;

/**
 *
 */
final class AttributesReader implements Reader
{
    public function extract(string $class): Result
    {
        try
        {
            $reflectionClass = new \ReflectionClass($class);

            return new Result(
                classLevelCollection: $this->classLevelAnnotations($reflectionClass),
                methodLevelCollection: $this->methodMethodAnnotations($reflectionClass)
            );
        }
        catch (\Throwable $throwable)
        {
            throw new ParseAttributesFailed($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
        }
    }

    private function methodMethodAnnotations(\ReflectionClass $reflectionClass): \SplObjectStorage
    {
        /** @psalm-var \SplObjectStorage<MethodLevel, int> $methodLevelCollection */
        $methodLevelCollection = new \SplObjectStorage();

        foreach ($reflectionClass->getMethods() as $reflectionMethod)
        {
            foreach ($reflectionMethod->getAttributes() as $reflectionAttribute)
            {
                /** @psalm-suppress ArgumentTypeCoercion */
                $methodLevelCollection->attach(
                    new MethodLevel(
                        attribute: $reflectionAttribute->newInstance(),
                        inClass: $reflectionClass->name,
                        reflectionMethod: $reflectionMethod
                    )
                );
            }
        }

        return $methodLevelCollection;
    }

    private function classLevelAnnotations(\ReflectionClass $reflectionClass): \SplObjectStorage
    {
        /** @psalm-var \SplObjectStorage<ClassLevel, int> $classLevelCollection */
        $classLevelCollection = new \SplObjectStorage();

        foreach ($reflectionClass->getAttributes() as $reflectionAttribute)
        {
            /** @psalm-suppress ArgumentTypeCoercion */
            $classLevelCollection->attach(
                new ClassLevel(
                    attribute: $reflectionAttribute->newInstance(),
                    inClass: $reflectionClass->name
                )
            );
        }

        return $classLevelCollection;
    }
}
