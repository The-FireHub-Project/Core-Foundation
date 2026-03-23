<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\LowLevel\ClsObj;
use FireHub\Tests\DataProviders\ {
    ClsObjDataProvider, TestAbstractClass, TestClass, TestInterface, TestTrait
};
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, Small, TestWith
};

/**
 * ### Test low-level Class & Object Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('support')]
#[Group('lowlevel')]
#[CoversClass(ClsObj::class)]
final class ClsObjTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testIsClass (string $name):void {

        self::assertTrue(ClsObj::isClass($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'nonExisting')]
    public function testIsNotClass (string $name):void {

        self::assertFalse(ClsObj::isClass($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'interfaces')]
    public function testIsInterface (string $name):void {

        self::assertTrue(ClsObj::isInterface($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'nonExisting')]
    public function testIsNotInterface (string $name):void {

        self::assertFalse(ClsObj::isInterface($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'enums')]
    public function testIsEnum (string $name):void {

        self::assertTrue(ClsObj::isEnum($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'nonExisting')]
    public function testIsNotEnum (string $name):void {

        self::assertFalse(ClsObj::isEnum($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'traits')]
    public function testIsTrait (string $name):void {

        self::assertTrue(ClsObj::isTrait($name));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $name
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'nonExisting')]
    public function testIsNotTrait (string $name):void {

        self::assertFalse(ClsObj::isTrait($name));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param non-empty-string $method
     *
     * @return void
     */
    #[TestWith([true, TestClass::class, 'methodOne'])]
    #[TestWith([false, TestClass::class, 'xxx'])]
    public function testMethodExist (bool $expected, string $class, string $method):void {

        self::assertSame($expected, ClsObj::methodExist($class, $method));
        self::assertSame($expected, ClsObj::methodExist(new $class, $method));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param non-empty-string $property
     *
     * @return void
     */
    #[TestWith([true, TestClass::class, 'var1'])]
    #[TestWith([false, TestClass::class, 'xxx'])]
    public function testPropertyExist (bool $expected, string $class, string $property):void {

        self::assertSame($expected, ClsObj::propertyExist($class, $property));
        self::assertSame($expected, ClsObj::propertyExist(new $class, $property));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $class
     * @param class-string $class1
     *
     * @return void
     */
    #[TestWith([true, TestClass::class, TestInterface::class])]
    #[TestWith([false, TestClass::class, 'xxx'])]
    public function testOfClass (bool $expected, string $class, string $class1):void {

        self::assertSame($expected, ClsObj::ofClass($class, $class1));
        self::assertSame($expected, ClsObj::ofClass(new $class, $class1));

    }

    /**
     * @since 1.0.0
     *
     * @param bool $expected
     * @param class-string $object_or_class
     * @param class-string $class
     *
     * @return void
     */
    #[TestWith([true, TestClass::class, TestAbstractClass::class])]
    #[TestWith([false, TestClass::class, 'xxx'])]
    public function testSubClassOf (bool $expected, string|object $object_or_class, string $class):void {

        self::assertSame($expected, ClsObj::subClassOf($object_or_class, $class));
        self::assertSame($expected, ClsObj::subClassOf(new $object_or_class, $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     * @param class-string $alias
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\FailedToCreateAliasError
     *
     * @return void
     */
    #[TestWith([TestClass::class, 'NewTestClass'])]
    public function testAlias (string $class, string $alias):void {

        ClsObj::alias($class, $alias);

        self::assertInstanceOf(\NewTestClass::class, new $class);

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testProperties (string $class):void {

        self::assertSame(['var1' => 'foo', 'var3' => null], ClsObj::properties($class));
        self::assertSame(['var1' => 'foo'], ClsObj::properties(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testMangledProperties ():void {

        $vars = ClsObj::mangledProperties(new TestClass());

        self::assertArrayHasKey('var1', $vars);

        self::assertArraysHaveIdenticalValues(['foo', 'bar'], $vars);

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testMethods (string $class):void {

        self::assertSame(['methodOne'], ClsObj::methods($class));
        self::assertSame(['methodOne'], ClsObj::methods(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testParentClass (string $class):void {

        self::assertSame(TestAbstractClass::class, ClsObj::parentClass($class));
        self::assertSame(TestAbstractClass::class, ClsObj::parentClass(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testParents (string $class):void {

        self::assertSame([TestAbstractClass::class => TestAbstractClass::class], ClsObj::parents($class));
        self::assertSame([TestAbstractClass::class => TestAbstractClass::class], ClsObj::parents(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testImplements (string $class):void {

        self::assertSame([TestInterface::class => TestInterface::class], ClsObj::implements($class));
        self::assertSame([TestInterface::class => TestInterface::class], ClsObj::implements(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\ClsObj\ClassDoesntExistError
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testUses (string $class):void {

        self::assertSame([TestTrait::class => TestTrait::class], ClsObj::uses($class));
        self::assertSame([TestTrait::class => TestTrait::class], ClsObj::uses(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testID (string $class):void {

        self::assertIsInt(ClsObj::id(new $class));

    }

    /**
     * @since 1.0.0
     *
     * @param class-string $class
     *
     * @return void
     */
    #[DataProviderExternal(ClsObjDataProvider::class, 'classes')]
    public function testHash (string $class):void {

        self::assertIsString(ClsObj::hash(new $class));

    }

}