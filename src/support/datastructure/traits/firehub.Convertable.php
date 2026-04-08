<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 */

namespace FireHub\Core\Support\DataStructure\Traits;

use FireHub\Core\Shared\Enums\Json\ {
    Flag, Flag\Encode, Flag\Decode
};
use FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError;
use FireHub\Core\Support\LowLevel\ {
    Data, DataIs, Json
};

/**
 * ### Convertable Trait
 *
 * A reusable trait that enables bidirectional conversion of data structures to and from array, JSON, and serialized
 * formats.<br>
 * It acts as a bridge between high-level data structures and low-level serialization mechanisms, ensuring consistent
 * encoding/decoding behavior across the system.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
trait Convertable {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    abstract public static function fromArray (array $array):static;

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = Collection::fromJson('["John","Jane","Jane","Jane","Richard","Richard"]');
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * @since 1.0.0
     *
     * @uses static::fromArray To create a data structure from an array.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::array To check if decoded JSON data is an array.
     * @uses \FireHub\Core\Support\LowLevel\JSON::decode() To decode $json data.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Json\DecodeError If JSON decoding throws an error.
     *
     * @return static<TKey, TValue>
     *
     * @note Method already includes Flag::JSON_THROW_ON_ERROR.
     */
    public static function fromJson (string $json, int $depth = 512, Flag|Decode ...$flags):static {

        /** @var static<TKey, TValue> */
        return static::fromArray(
            DataIs::array($data = JSON::decode($json, true, $depth, ...$flags))
                ? $data : []
        );

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->toJson();
     *
     * // '["John","Jane","Jane","Jane","Richard","Richard"]'
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Json::encode() As JSON representation of an object.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Json\EncodeError If JSON encoding throws an error.
     *
     * @note Method already includes Flag::JSON_THROW_ON_ERROR.
     */
    public function toJson (int $depth = 512, Flag|Encode ...$flags):string {

        return Json::encode($this, $depth, ...$flags);

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * $collection = new Collection(['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']);
     *
     * $collection->serialize();
     *
     * // serialized collection class
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Data::serialize() To generate a storable representation of an object.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\CannotSerializeError If try to serialize an anonymous class,
     * function, or resource.
     *
     * @note This is a binary string that may include null bytes and needs to be stored and handled as such.
     * For example, Data::serialize() output should generally be stored in a BLOB field in a database, rather than
     * a CHAR or TEXT field.
     */
    public function serialize ():string {

        return Data::serialize($this);

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\Collection;
     *
     * Collection::unserialize( //serialized collection class);
     *
     * // ['John', 'Jane', 'Jane', 'Jane', 'Richard', 'Richard']
     * </code>
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Data::unserialize() To create an object from a stored representation.
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError If couldn't unserialize data, $data is
     * already false, $data is NULL, or $data is not from this class.
     *
     * @return static<TKey, TValue>
     */
    public static function unserialize (string $data, int $max_depth = 4096):static {

        /** @var static<TKey, TValue> */
        return ($data = Data::unserialize($data, true, $max_depth)) instanceof static
            ? $data : throw UnserializeFailedError::builder()
                ->withContext([
                    'excepted_class' => static::class,
                    'data' => $data
                ])
                ->build();

    }

}