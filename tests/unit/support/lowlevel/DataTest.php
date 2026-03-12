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
use FireHub\Core\Shared\Enums\Data\Type;
use FireHub\Core\Throwable\Error\LowLevel\Data\ {
    ArrayToStringConversionError, CannotSerializeError, SetAsResourceError, UnserializeFailedError
};
use FireHub\Core\Support\LowLevel\ {
    Data, DataIs
};
use FireHub\Tests\DataProviders\DataDataProvider;
use PHPUnit\Framework\Attributes\ {
    CoversClass, DataProviderExternal, Group, SmalL, TestWith
};

/**
 * ### Test low-level data operations proxy
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(Data::class)]
#[CoversClass(DataIs::class)]
final class DataTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testArray (mixed $value, Type $type):void {

        self::assertTrue(DataIs::array($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotArray (mixed $value, Type $type):void {

        self::assertFalse(DataIs::array($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testBool (mixed $value, Type $type):void {

        self::assertTrue(DataIs::bool($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotBool (mixed $value, Type $type):void {

        self::assertFalse(DataIs::bool($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    public function testCallable (mixed $value, Type $type):void {

        self::assertTrue(DataIs::callable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotCallable (mixed $value, Type $type):void {

        self::assertFalse(DataIs::callable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testCountable (mixed $value, Type $type):void {

        self::assertTrue(DataIs::countable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotCountable (mixed $value, Type $type):void {

        self::assertFalse(DataIs::countable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    public function testFloat (mixed $value, Type $type):void {

        self::assertTrue(DataIs::float($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotFloat (mixed $value, Type $type):void {

        self::assertFalse(DataIs::float($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    public function testInt (mixed $value, Type $type):void {

        self::assertTrue(DataIs::int($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotInt (mixed $value, Type $type):void {

        self::assertFalse(DataIs::int($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testIterable (mixed $value, Type $type):void {

        self::assertTrue(DataIs::iterable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotIterable (mixed $value, Type $type):void {

        self::assertFalse(DataIs::iterable($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    public function testNull (mixed $value, Type $type):void {

        self::assertTrue(DataIs::null($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotNull (mixed $value, Type $type):void {

        self::assertFalse(DataIs::null($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    public function testNumeric (mixed $value, Type $type):void {

        self::assertTrue(DataIs::numeric($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotNumeric (mixed $value, Type $type):void {

        self::assertFalse(DataIs::numeric($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testObject (mixed $value, Type $type):void {

        self::assertTrue(DataIs::object($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotObject (mixed $value, Type $type):void {

        self::assertFalse(DataIs::object($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testResource (mixed $value, Type $type):void {

        self::assertTrue(DataIs::resource($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testNotResource (mixed $value, Type $type):void {

        self::assertFalse(DataIs::resource($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    public function testScalar (mixed $value, Type $type):void {

        self::assertTrue(DataIs::scalar($value));

    }


    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotsScalar (mixed $value, Type $type):void {

        self::assertFalse(DataIs::scalar($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testString (mixed $value, Type $type):void {

        self::assertTrue(DataIs::string($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testNotString (mixed $value, Type $type):void {

        self::assertFalse(DataIs::string($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    public function testGetDebugType (mixed $value, Type $type):void {

        self::assertSame('string', Data::getDebugType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    #[DataProviderExternal(DataDataProvider::class, 'closedResource')]
    public function testGetType (mixed $value, Type $type):void {

        self::assertSame($type, Data::getType($value));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\ArrayToStringConversionError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\FailedToSetTypeError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\SetAsResourceError
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testSetType (mixed $value, Type $type):void {

        self::assertSame($value, Data::setType($value, $type));

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\FailedToSetTypeError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\SetAsResourceError
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    public function testSetTypeStringFromArray (mixed $value, Type $type):void {

        $this->expectException(ArrayToStringConversionError::class);

        Data::setType($value, Type::T_STRING);

    }

    /**
     * @since 1.0.0
     *
     * @param mixed $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\ArrayToStringConversionError
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\FailedToSetTypeError
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'string')]
    #[DataProviderExternal(DataDataProvider::class, 'int')]
    #[DataProviderExternal(DataDataProvider::class, 'float')]
    #[DataProviderExternal(DataDataProvider::class, 'array')]
    #[DataProviderExternal(DataDataProvider::class, 'null')]
    #[DataProviderExternal(DataDataProvider::class, 'bool')]
    #[DataProviderExternal(DataDataProvider::class, 'callable')]
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    #[DataProviderExternal(DataDataProvider::class, 'resource')]
    public function testSetTypeFromResource (mixed $value, Type $type):void {

        $this->expectException(SetAsResourceError::class);

        Data::setType($value, Type::T_RESOURCE);

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value
     * @param string $result
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\CannotSerializeError
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 'a:3:{s:3:"one";i:1;s:3:"two";i:2;s:5:"three";i:3;}'])]
    #[TestWith(['This is long string.', 's:20:"This is long string.";'])]
    public function testSerialize (null|string|int|float|bool|array|object $value, string $result):void {

        self::assertSame($result, Data::serialize($value));

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value
     * @param \FireHub\Core\Shared\Enums\Data\Type $type
     *
     * @return void
     */
    #[DataProviderExternal(DataDataProvider::class, 'countable')]
    public function testSerializeAnonymousClasses (null|string|int|float|bool|array|object $value, Type $type):void {

        $this->expectException(CannotSerializeError::class);

        Data::serialize($value);

    }

    /**
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $result
     * @param string $value
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError
     *
     * @return void
     */
    #[TestWith([['one' => 1, 'two' => 2, 'three' => 3], 'a:3:{s:3:"one";i:1;s:3:"two";i:2;s:5:"three";i:3;}'])]
    #[TestWith(['This is long string.', 's:20:"This is long string.";'])]
    public function testUnserialize (null|string|int|float|bool|array|object $result, string $value):void {

        self::assertSame($result, Data::unserialize($value));

    }

    /**
     * @since 1.0.0
     *
     * @param string $value
     *
     * @return void
     */
    #[TestWith(['b:0;'])]
    #[TestWith(['N;'])]
    public function testUnserializeFalse (string $value):void {

        $this->expectException(UnserializeFailedError::class);

        Data::unserialize($value);

    }

}