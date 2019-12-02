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
    public object $annotation;

    /**
     * The class containing the annotation.
     *
     * @psalm-var class-string
     */
    public string $inClass;

    public \ReflectionMethod$reflectionMethod;

    /**
     * @psalm-param  class-string $inClass
     */
    public function __construct(object $annotation, string $inClass, \ReflectionMethod $reflectionMethod)
    {
        $this->annotation       = $annotation;
        $this->inClass          = $inClass;
        $this->reflectionMethod = $reflectionMethod;
    }
}
