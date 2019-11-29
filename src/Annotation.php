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

/**
 * Annotation data.
 *
 * @psalm-readonly
 */
final class Annotation
{
    private const TYPE_CLASS_LEVEL  = 'class_level';

    private const TYPE_METHOD_LEVEL = 'method_level';

    /**
     * Annotation.
     */
    public object $annotationObject;

    /**
     * Annotation type.
     *
     * @see self::TYPE_*
     */
    public string $type;

    /**
     * The class containing the annotation.
     *
     * @psalm-var class-string
     */
    public string $inClass;

    /**
     * Specified if type = method_level.
     */
    public ?\ReflectionMethod$reflectionMethod;

    /**
     * Creating a method level annotation VO.
     *
     * @psalm-param class-string $inClass
     */
    public static function methodLevel(\ReflectionMethod $method, object $annotation, string $inClass): self
    {
        return new self(self::TYPE_METHOD_LEVEL, $annotation, $inClass, $method);
    }

    /**
     * Creating a method level annotation.
     *
     * @psalm-param class-string $inClass
     */
    public static function classLevel(object $annotation, string $inClass): self
    {
        return new self(self::TYPE_CLASS_LEVEL, $annotation, $inClass);
    }

    /**
     * Is a class-level annotation?
     */
    public function isClassLevel(): bool
    {
        return self::TYPE_CLASS_LEVEL === $this->type;
    }

    /**
     * Is a method-level annotation?
     */
    public function isMethodLevel(): bool
    {
        return self::TYPE_METHOD_LEVEL === $this->type;
    }

    /**
     * @psalm-param class-string $inClass
     */
    private function __construct(string $type, object $annotation, string $inClass, ?\ReflectionMethod $method = null)
    {
        $this->type             = $type;
        $this->annotationObject = $annotation;
        $this->inClass          = $inClass;
        $this->reflectionMethod = $method;
    }
}
