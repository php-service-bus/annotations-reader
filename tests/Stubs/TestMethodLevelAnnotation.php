<?php

/**
 * PHP Service Bus (publish-subscribe pattern) annotations reader component
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Tests\Stubs;

/**
 * @Annotation
 * @Target("METHOD")
 */
final class TestMethodLevelAnnotation
{
    /**
     * @var string
     */
    private $property;

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data)
    {
        foreach($data as $key => $value)
        {
            $this->{$key} = $value;
        }
    }

    /**
     * @return string
     */
    public function property(): string
    {
        return $this->property;
    }
}
