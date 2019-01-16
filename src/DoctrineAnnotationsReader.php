<?php

/**
 * PHP Service Bus (publish-subscribe pattern implementation) annotations reader component
 *
 * @author  Maksim Masiukevich <desperado@minsk-info.ru>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace Desperado\ServiceBus\AnnotationsReader;

use Desperado\ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed;
use Desperado\ServiceBus\AnnotationsReader\Exceptions\ParserConfigurationError;
use Doctrine\Common\Annotations as DoctrineAnnotations;

/**
 * Doctrine2 annotations reader
 */
class DoctrineAnnotationsReader implements AnnotationsReader
{
    /**
     * Annotations reader
     *
     * @var DoctrineAnnotations\Reader
     */
    private $reader;

    /**
     * @param DoctrineAnnotations\Reader|null $reader
     * @param array<array-key, string> $ignoredNames
     *
     * @throws \Desperado\ServiceBus\AnnotationsReader\Exceptions\ParserConfigurationError
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

            foreach($ignoredNames as $ignoredName)
            {
                DoctrineAnnotations\AnnotationReader::addGlobalIgnoredName($ignoredName);
            }
        }
            // @codeCoverageIgnoreStart
        catch(\Throwable $throwable)
        {
            throw new ParserConfigurationError($throwable->getMessage());
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @inheritdoc
     */
    public function extract(string $class): AnnotationCollection
    {
        try
        {
            $reflectionClass = new \ReflectionClass($class);
            $collection      = new AnnotationCollection();

            $collection->push(
                $this->loadClassLevelAnnotations($reflectionClass)
            );

            $collection->push(
                $this->loadMethodLevelAnnotations($reflectionClass)
            );

            return $collection;
        }
        catch(\Throwable $throwable)
        {
            throw new ParseAnnotationFailed($throwable->getMessage(), (int) $throwable->getCode(), $throwable);
        }
    }

    /**
     * Gets the annotations applied to a class
     *
     * @param \ReflectionClass $class
     *
     * @return array<array-key, \Desperado\ServiceBus\AnnotationsReader\Annotation>
     */
    private function loadClassLevelAnnotations(\ReflectionClass $class): array
    {
        return \array_map(
            static function(object $sagaAnnotation) use ($class): Annotation
            {
                return Annotation::classLevel($sagaAnnotation, $class->getName());
            },
            $this->reader->getClassAnnotations($class)
        );
    }

    /**
     * Gets the annotations applied to a method
     *
     * @param \ReflectionClass $class
     *
     * @return array<array-key, \Desperado\ServiceBus\AnnotationsReader\Annotation>
     */
    private function loadMethodLevelAnnotations(\ReflectionClass $class): array
    {
        $annotations = [];

        foreach($class->getMethods() as $method)
        {
            $methodAnnotations = $this->reader->getMethodAnnotations($method);

            /** @var object $methodAnnotation */
            foreach($methodAnnotations as $methodAnnotation)
            {
                $annotations[] = Annotation::methodLevel($method, $methodAnnotation, $class->getName());
            }
        }

        return $annotations;
    }
}