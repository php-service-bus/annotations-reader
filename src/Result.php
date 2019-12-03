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

use ServiceBus\AnnotationsReader\Annotation\ClassLevel;
use ServiceBus\AnnotationsReader\Annotation\MethodLevel;

/**
 *
 */
final class Result
{
    /** @var \SplObjectStorage */
    public $classLevelCollection;

    /** @var \SplObjectStorage */
    public $methodLevelCollection;

    public function __construct()
    {
        $this->classLevelCollection  = new \SplObjectStorage();
        $this->methodLevelCollection = new \SplObjectStorage();
    }

    public function addClassLevelAnnotation(ClassLevel $classLevel): void
    {
        $this->classLevelCollection->attach($classLevel);
    }

    public function addMethodAnnotation(MethodLevel $classLevel): void
    {
        $this->methodLevelCollection->attach($classLevel);
    }
}
