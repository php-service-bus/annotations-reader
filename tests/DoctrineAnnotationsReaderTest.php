<?php

/**
 * PHP Service Bus annotations reader component
 *
 * @author  Maksim Masiukevich <dev@async-php.com>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Tests;

use ServiceBus\AnnotationsReader\DoctrineAnnotationsReader;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithCorrectAnnotations;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithIncorrectAnnotation;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestClassLevelAnnotation;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestMethodLevelAnnotation;
use PHPUnit\Framework\TestCase;

/**
 *
 */
final class DoctrineAnnotationsReaderTest extends TestCase
{
    /**
     * @test
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function parseEmptyClass(): void
    {
        $object = new class()
        {

        };

        $annotations = (new DoctrineAnnotationsReader())->extract(\get_class($object));

        static::assertEmpty($annotations);
    }

    /**
     * @test
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function parseClassWithAnnotations(): void
    {
        $annotations = (new DoctrineAnnotationsReader())->extract(ClassWithCorrectAnnotations::class);

        static::assertNotEmpty($annotations);
        static::assertCount(2, $annotations);

        $classLevelAnnotations  = $annotations->classLevelAnnotations();
        $methodLevelAnnotations = $annotations->methodLevelAnnotations();

        static::assertCount(1, $classLevelAnnotations);
        static::assertCount(1, $methodLevelAnnotations);

        foreach($classLevelAnnotations as $annotation)
        {
            /** @var \ServiceBus\AnnotationsReader\Annotation $annotation */

            static::assertNull($annotation->reflectionMethod);
            static::assertEquals(ClassWithCorrectAnnotations::class, $annotation->inClass);
            static::assertEquals('class_level', $annotation->type);
            static::assertTrue($annotation->isClassLevel());
            static::assertFalse($annotation->isMethodLevel());
            /** @noinspection UnnecessaryAssertionInspection */
            static::assertInstanceOf(TestClassLevelAnnotation::class, $annotation->annotationObject);
        }

        foreach($methodLevelAnnotations as $annotation)
        {
            /** @var \ServiceBus\AnnotationsReader\Annotation $annotation */

            static::assertNotNull($annotation->reflectionMethod);
            static::assertEquals(ClassWithCorrectAnnotations::class, $annotation->inClass);
            static::assertEquals('method_level', $annotation->type);
            static::assertFalse($annotation->isClassLevel());
            /** @noinspection UnnecessaryAssertionInspection */
            static::assertInstanceOf(TestMethodLevelAnnotation::class, $annotation->annotationObject);
        }
    }

    /**
     * @test
     * @expectedException \ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function parseClassWithErrors(): void
    {
        (new DoctrineAnnotationsReader(null, ['psalm']))->extract(ClassWithIncorrectAnnotation::class);
    }

    /**
     * @test
     * @expectedException \ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     *
     * @return void
     *
     * @throws \Throwable
     */
    public function parseNotExistsClass(): void
    {
        (new DoctrineAnnotationsReader())->extract('qwerty');
    }
}
