<?php

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Tests;

use PHPUnit\Framework\TestCase;
use ServiceBus\AnnotationsReader\Annotation\ClassLevel;
use ServiceBus\AnnotationsReader\Annotation\MethodLevel;
use ServiceBus\AnnotationsReader\DoctrineReader;
use ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithCorrectAnnotations;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithIncorrectAnnotation;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestClassLevelAnnotation;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestMethodLevelAnnotation;

/**
 *
 */
final class DoctrineAnnotationsReaderTest extends TestCase
{
    /**
     * @test
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public function parseEmptyClass(): void
    {
        $object = new class()
        {
        };

        $annotations = (new DoctrineReader())->extract(\get_class($object));

        static::assertCount(0, $annotations->methodLevelCollection);
        static::assertCount(0, $annotations->classLevelCollection);
    }

    /**
     * @test
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public function parseClassWithAnnotations(): void
    {
        $result = (new DoctrineReader())->extract(ClassWithCorrectAnnotations::class);

        static::assertCount(1, $result->classLevelCollection);
        static::assertCount(1, $result->methodLevelCollection);

        $classLevelAnnotations  = $result->classLevelCollection;
        $methodLevelAnnotations =$result->methodLevelCollection;

        static::assertCount(1, $classLevelAnnotations);
        static::assertCount(1, $methodLevelAnnotations);

        /** @var ClassLevel $annotation */
        foreach ($classLevelAnnotations as $annotation)
        {
            static::assertSame(ClassWithCorrectAnnotations::class, $annotation->inClass);
            static::assertInstanceOf(TestClassLevelAnnotation::class, $annotation->annotation);
        }

        /** @var MethodLevel $annotation */
        foreach ($methodLevelAnnotations as $annotation)
        {
            static::assertNotNull($annotation->reflectionMethod);
            static::assertSame(ClassWithCorrectAnnotations::class, $annotation->inClass);
            static::assertInstanceOf(TestMethodLevelAnnotation::class, $annotation->annotation);
        }
    }

    /**
     * @test
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public function parseClassWithErrors(): void
    {
        $this->expectException(ParseAnnotationFailed::class);

        (new DoctrineReader(null, ['psalm']))->extract(ClassWithIncorrectAnnotation::class);
    }

    /**
     * @test
     *
     * @throws \Throwable
     *
     * @return void
     *
     */
    public function parseNotExistsClass(): void
    {
        $this->expectException(ParseAnnotationFailed::class);

        (new DoctrineReader())->extract('qwerty');
    }
}
