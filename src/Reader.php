<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 0);

namespace ServiceBus\AnnotationsReader;

/**
 * Attributes extractor.
 */
interface Reader
{
    /**
     * Extract class/method level annotations.
     *
     * @psalm-param class-string $class
     *
     * @throws \ServiceBus\AnnotationsReader\Exceptions\ParseAttributesFailed
     */
    public function extract(string $class): Result;
}
