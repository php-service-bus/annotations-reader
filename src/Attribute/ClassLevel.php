<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=0);

namespace ServiceBus\AnnotationsReader\Attribute;

/**
 * @psalm-immutable
 */
final class ClassLevel
{
    /**
     * Origin attribute object
     *
     * @psalm-readonly
     *
     * @var object
     */
    public $attribute;

    /**
     * The class containing the annotation.
     *
     * @psalm-readonly
     * @psalm-var class-string
     *
     * @var string
     */
    public $inClass;

    /**
     * @psalm-param class-string $inClass
     */
    public function __construct(object $attribute, string $inClass)
    {
        $this->attribute = $attribute;
        $this->inClass   = $inClass;
    }
}
