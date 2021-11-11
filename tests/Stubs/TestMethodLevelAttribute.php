<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace ServiceBus\AnnotationsReader\Tests\Stubs;

#[\Attribute(\Attribute::TARGET_METHOD)]
final class TestMethodLevelAttribute
{
    /**
     * @var string
     */
    public $property;

    public function __construct(string $property)
    {
        $this->property = $property;
    }
}
