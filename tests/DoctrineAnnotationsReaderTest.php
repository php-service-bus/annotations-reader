<?php

/**
 * PHP Service Bus (publish-subscribe pattern implementation) annotations reader component
 *
 * @author  Maksim Masiukevich <desperado@minsk-info.ru>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace Desperado\ServiceBus\AnnotationsReader\Tests;

use Desperado\ServiceBus\AnnotationsReader\DoctrineAnnotationsReader;
use Desperado\ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithCorrectAnnotations;
use Desperado\ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithIncorrectAnnotation;
use Desperado\ServiceBus\AnnotationsReader\Tests\Stubs\TestClassLevelAnnotation;
use Desperado\ServiceBus\AnnotationsReader\Tests\Stubs\TestMethodLevelAnnotation;
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
            /** @var \Desperado\ServiceBus\AnnotationsReader\Annotation $annotation */

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
            /** @var \Desperado\ServiceBus\AnnotationsReader\Annotation $annotation */

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
     * @expectedException \Desperado\ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     *
     * @return void
     */
    public function parseClassWithErrors(): void
    {
        (new DoctrineAnnotationsReader(null, ['psalm']))->extract(ClassWithIncorrectAnnotation::class);
    }

    /**
     * @test
     * @expectedException \Desperado\ServiceBus\AnnotationsReader\Exceptions\ParseAnnotationFailed
     *
     * @return void
     */
    public function parseNotExistsClass(): void
    {
        (new DoctrineAnnotationsReader())->extract('qwerty');
    }
}
