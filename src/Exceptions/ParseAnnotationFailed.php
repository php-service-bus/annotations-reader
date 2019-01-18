<?php

/**
 * PHP Service Bus (publish-subscribe pattern) annotations reader component
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Exceptions;

/**
 *
 */
final class ParseAnnotationFailed extends \RuntimeException implements AnnotationsReaderExceptionMarker
{

}
