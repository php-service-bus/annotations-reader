<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types=0);

namespace ServiceBus\AnnotationsReader;

use ServiceBus\AnnotationsReader\Attribute\ClassLevel;
use ServiceBus\AnnotationsReader\Attribute\MethodLevel;

/**
 * @psalm-immutable
 */
final class Result
{
    /**
     * @psalm-readonly
     * @psalm-var \SplObjectStorage<ClassLevel, null>
     *
     * @var \SplObjectStorage
     */
    public $classLevelCollection;

    /**
     * @psalm-readonly
     * @psalm-var \SplObjectStorage<MethodLevel, null>
     *
     * @var \SplObjectStorage
     */
    public $methodLevelCollection;

    /**
     * @psalm-param \SplObjectStorage<ClassLevel, null> $classLevelCollection
     * @psalm-param \SplObjectStorage<MethodLevel, null> $methodLevelCollection
     */
    public function __construct(\SplObjectStorage $classLevelCollection, \SplObjectStorage $methodLevelCollection)
    {
        $this->classLevelCollection  = $classLevelCollection;
        $this->methodLevelCollection = $methodLevelCollection;
    }
}
