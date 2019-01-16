<?php

/**
 * PHP Service Bus (publish-subscribe pattern implementation) annotations reader component
 *
 * @author  Maksim Masiukevich <desperado@minsk-info.ru>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace Desperado\ServiceBus\AnnotationsReader\Tests\Stubs;

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