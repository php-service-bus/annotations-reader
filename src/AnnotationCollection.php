<?php

/**
 * PHP Service Bus annotations reader component
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader;

/**
 *
 */
final class AnnotationCollection implements \Countable, \IteratorAggregate
{
    /**
     * Annotations
     *
     * @var array<array-key, \ServiceBus\AnnotationsReader\Annotation>
     */
    private $collection = [];

    /**
     * @param array<array-key, \ServiceBus\AnnotationsReader\Annotation> $annotations
     */
    public function __construct(array $annotations = [])
    {
        $this->push($annotations);
    }

    /**
     * Push multiple annotations
     *
     * @param array<array-key, \ServiceBus\AnnotationsReader\Annotation> $annotations
     *
     * @return void
     */
    public function push(array $annotations): void
    {
        foreach($annotations as $annotation)
        {
            $this->add($annotation);
        }
    }

    /**
     * Add annotation data to collection
     *
     * @param Annotation $annotation
     *
     * @return void
     */
    public function add(Annotation $annotation): void
    {
        $this->collection[\spl_object_hash($annotation)] = $annotation;
    }

    /**
     * Filter collection data
     *
     * @param callable(Annotation):?Annotation $callable
     *
     * @return AnnotationCollection
     */
    public function filter(callable $callable): AnnotationCollection
    {
        /** @var array<array-key, \ServiceBus\AnnotationsReader\Annotation> $annotations */
        $annotations = \array_filter($this->collection, $callable);

        return new AnnotationCollection($annotations);
    }

    /**
     * Find all method-level annotations
     *
     * @return AnnotationCollection
     */
    public function methodLevelAnnotations(): AnnotationCollection
    {
        return $this->filter(
            static function(Annotation $annotation): ?Annotation
            {
                return false === $annotation->isClassLevel()
                    ? $annotation
                    : null;
            }
        );
    }

    /**
     * Find all class-level annotations
     *
     * @return AnnotationCollection
     */
    public function classLevelAnnotations(): AnnotationCollection
    {
        return $this->filter(
            static function(Annotation $annotation): ?Annotation
            {
                return true === $annotation->isClassLevel()
                    ? $annotation
                    : null;
            }
        );
    }

    /**
     * @inheritdoc
     */
    public function getIterator(): \Generator
    {
        return yield from $this->collection;
    }

    /**
     * @inheritdoc
     */
    public function count(): int
    {
        return \count($this->collection);
    }
}
