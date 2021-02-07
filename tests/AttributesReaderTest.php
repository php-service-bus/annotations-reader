<?php /** @noinspection PhpUnhandledExceptionInspection */

/**
 * PHP Service Bus annotations reader component.
 *
 * @author  Maksim Masiukevich <contacts@desperado.dev>
 * @license MIT
 * @license https://opensource.org/licenses/MIT
 */

declare(strict_types = 1);

namespace ServiceBus\AnnotationsReader\Tests;

use PHPUnit\Framework\TestCase;
use ServiceBus\AnnotationsReader\Attribute\ClassLevel;
use ServiceBus\AnnotationsReader\Attribute\MethodLevel;
use ServiceBus\AnnotationsReader\AttributesReader;
use ServiceBus\AnnotationsReader\Exceptions\ParseAttributesFailed;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithCorrectAttributes;
use ServiceBus\AnnotationsReader\Tests\Stubs\ClassWithIncorrectAttribute;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestClassLevelAttribute;
use ServiceBus\AnnotationsReader\Tests\Stubs\TestMethodLevelAttribute;

/**
 *
 */
final class AttributesReaderTest extends TestCase
{
    /**
     * @test
     */
    public function parseEmptyClass(): void
    {
        $object = new class()
        {
        };

        $annotations = (new AttributesReader())->extract(\get_class($object));

        self::assertCount(0, $annotations->methodLevelCollection);
        self::assertCount(0, $annotations->classLevelCollection);
    }

    /**
     * @test
     */
    public function parseClassWithAnnotations(): void
    {
        $result = (new AttributesReader())->extract(ClassWithCorrectAttributes::class);

        self::assertCount(1, $result->classLevelCollection);
        self::assertCount(1, $result->methodLevelCollection);

        $classLevelAnnotations  = $result->classLevelCollection;
        $methodLevelAnnotations =$result->methodLevelCollection;

        self::assertCount(1, $classLevelAnnotations);
        self::assertCount(1, $methodLevelAnnotations);

        /** @var ClassLevel $classLevelAttribute */
        foreach ($classLevelAnnotations as $classLevelAttribute)
        {
            self::assertSame(ClassWithCorrectAttributes::class, $classLevelAttribute->inClass);
            self::assertInstanceOf(TestClassLevelAttribute::class, $classLevelAttribute->attribute);
        }

        /** @var MethodLevel $methodLevelAttribute */
        foreach ($methodLevelAnnotations as $classLevelAttribute)
        {
            self::assertNotNull($classLevelAttribute->reflectionMethod);
            self::assertSame(ClassWithCorrectAttributes::class, $classLevelAttribute->inClass);
            self::assertInstanceOf(TestMethodLevelAttribute::class, $classLevelAttribute->attribute);
        }
    }

    /**
     * @test
     */
    public function parseClassWithErrors(): void
    {
        $this->expectException(ParseAttributesFailed::class);

        (new AttributesReader())->extract(ClassWithIncorrectAttribute::class);
    }
}
