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
 * Annotation extractor.
 */
interface Reader
{
    /**
     * Extract class/method level annotations.
     *
     * @psalm-param class-string $class
     *
     * @throws \ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     */
    public function extract(string $class): Result;
}
