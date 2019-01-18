<?php

/**
 * PHP Service Bus (publish-subscribe pattern) annotations reader component
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader;

/**
 * Annotation extractor
 */
interface AnnotationsReader
{
    /**
     * Extract class/method level annotations
     *
     * @param string $class
     *
     * @return AnnotationCollection
     *
     * @throws \ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     */
    public function extract(string $class): AnnotationCollection;
}

