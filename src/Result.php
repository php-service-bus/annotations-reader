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
 * @psalm-immutable
 */
final class Result
{
    /**
     * @psalm-readonly
     *
     * @var \SplObjectStorage
     */
    public $classLevelCollection;

    /**
     * @psalm-readonly
     *
     * @var \SplObjectStorage
     */
    public $methodLevelCollection;

    public function __construct(\SplObjectStorage $classLevelCollection, \SplObjectStorage $methodLevelCollection)
    {
        $this->classLevelCollection  = $classLevelCollection;
        $this->methodLevelCollection = $methodLevelCollection;
    }
}
