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
final class ClassLevel
{
    /** Origin annotation object */
    public $annotation;

    /** The class containing the annotation. */
    public $inClass;

    /**
     * @psalm-assert class-string $inClass
     */
    public function __construct(object $annotation, string $inClass)
    {
        $this->annotation = $annotation;
        $this->inClass    = $inClass;
    }
}
