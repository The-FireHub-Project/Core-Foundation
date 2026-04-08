<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 */

namespace FireHub\Tests\DataProviders;

use Countable, IteratorAggregate, SplFixedArray, Traversable;

/**
 * ### Class data provider
 * @since 1.0.0
 */
final class ClsObjDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<object<Countable>>>
     */
    public static function countable ():array {

        return [
            [new class implements Countable {

                public function count():int {return 10;}

            }]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<object<\Iterator>>
     */
    public static function iterator ():array {

        return [
            [new class implements Countable, IteratorAggregate {
                public array $data = [1 => 'one', 2 => 'two', 3 => 'three'];
                public function count ():int {return 3;}
                public function getIterator ():Traversable {yield from $this->data;}
            }]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<object<SplFixedArray>>
     */
    public static function splFixedArray ():array {

        $iterator = new SplFixedArray(3);
        $iterator[0] = 1;
        $iterator[1] = 2;
        $iterator[2] = 3;

        return [
            [$iterator]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function abstractClasses ():array {

        return [
            [TestAbstractClass::class]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function classes ():array {

        return [
            [TestClass::class]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function interfaces ():array {

        return [
            [TestInterface::class]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function enums ():array {

        return [
            [TestEnum::class]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function traits ():array {

        return [
            [TestTrait::class]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<class-string>>
     */
    public static function nonExisting ():array {

        return [
            ['NonExistingClass']
        ];

    }

}

abstract class TestAbstractClass {
}

class TestClass extends TestAbstractClass implements TestInterface {
    use TestTrait;

    public string $var1 = 'foo';
    protected string $var2 = 'bar';
    public string $var3;

    public function methodOne ():void {}

    protected function methodTwo ():void {}
}

interface TestInterface {}

trait TestTrait {}

enum TestEnum {}