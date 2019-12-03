<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Annotation;

/**
 * @psalm-readonly
 */
final class MethodLevel
{
    /** Origin annotation object */
    public $annotation;

    /** The class containing the annotation. */
    public $inClass;

    public $reflectionMethod;

    /**
     * @psalm-assert class-string $inClass
     */
    public function __construct(object $annotation, string $inClass, \ReflectionMethod $reflectionMethod)
    {
        $this->annotation       = $annotation;
        $this->inClass          = $inClass;
        $this->reflectionMethod = $reflectionMethod;
    }
}
