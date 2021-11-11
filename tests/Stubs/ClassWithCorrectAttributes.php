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

#[TestClassLevelAttribute('property: some value')]
final class ClassWithCorrectAttributes
{
    #[TestMethodLevelAttribute('property: some value')]
    private function methodLevel(): void
    {
    }
}
