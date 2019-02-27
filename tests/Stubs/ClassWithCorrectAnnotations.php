<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Tests\Stubs;

/**
 * @TestClassLevelAnnotation
 */
final class ClassWithCorrectAnnotations
{
    /**
     * @noinspection PhpUnusedPrivateMethodInspection
     *
     * @TestMethodLevelAnnotation
     *
     * @return void
     */
    private function methodLevel(): void
    {
    }
}
