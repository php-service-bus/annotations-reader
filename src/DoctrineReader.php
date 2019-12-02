<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader;

use Doctrine\Common\Annotations as DoctrineAnnotations;
use ServiceBus\AnnotationsReader\Annotation\ClassLevel;
use ServiceBus\AnnotationsReader\Annotation\MethodLevel;
use ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed;
use ServiceBus\AnnotationsReader\Exceptions\ParserConfigurationError;

/**
 * Doctrine2 annotations reader.
 */
class DoctrineReader implements Reader
{
    /**
     * Annotations reader.
     */
    private DoctrineAnnotations\Reader $reader;

    /**
     * @psalm-param array<array-key, string> $ignoredNames
     *
     * @param string[] $ignoredNames
     *
     * @throws \ServiceBus\AnnotationsReader\Exceptions\ParserConfigurationError
     */
    public function __construct(DoctrineAnnotations\Reader $reader = null, array $ignoredNames = [])
    {
        try
        {
            /**
             * @noinspection   PhpDeprecationInspection
             * @psalm-suppress DeprecatedMethod This method is deprecated and will be removed in doctrine/annotations 2.0
             */
            DoctrineAnnotations\AnnotationRegistry::registerLoader('class_exists');

            $this->reader = $reader ?? new DoctrineAnnotations\AnnotationReader();

            foreach ($ignoredNames as $ignoredName)
            {
                DoctrineAnnotations\AnnotationReader::addGlobalIgnoredName($ignoredName);
            }
        }
        // @codeCoverageIgnoreStart
        catch (\Throwable $throwable)
        {
            throw new ParserConfigurationError($throwable->getMessage());
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * {@inheritdoc}
     */
    public function extract(string $class): Result
    {
        try
        {
            $reflectionClass = new \ReflectionClass($class);
            $result          = new Result();

            foreach ($this->loadClassLevelAnnotations($reflectionClass) as $annotation)
            {
                $result->addClassLevelAnnotation($annotation);
            }

            foreach ($this->loadMethodLevelAnnotations($reflectionClass) as $annotation)
            {
                $result->addMethodAnnotation($annotation);
            }

            return $result;
        }
        catch (\Throwable $throwable)
        {
            throw new ParseAnnotationFailed($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
        }
    }

    /**
     * Gets the annotations applied to a class.
     *
     * @return ClassLevel[]
     */
    private function loadClassLevelAnnotations(\ReflectionClass $class): array
    {
        return \array_map(
            static function (object $sagaAnnotation) use ($class): ClassLevel
            {
                return new ClassLevel($sagaAnnotation, $class->getName());
            },
            $this->reader->getClassAnnotations($class)
        );
    }

    /**
     * Gets the annotations applied to a method.
     *
     * @return MethodLevel[]
     */
    private function loadMethodLevelAnnotations(\ReflectionClass $class): array
    {
        $annotations = [];

        foreach ($class->getMethods() as $method)
        {
            $methodAnnotations = $this->reader->getMethodAnnotations($method);

            /** @var object $methodAnnotation */
            foreach ($methodAnnotations as $methodAnnotation)
            {
                $annotations[] = new MethodLevel($methodAnnotation, $class->getName(), $method);
            }
        }

        return $annotations;
    }
}
