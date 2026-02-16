<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.4
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\Data\Type;
use FireHub\Core\Throwable\Error\LowLevel\Data\ {
    ArrayToStringConversionError, CannotSerializeError, FailedToSetTypeError, SetAsResourceError, TypeUnknownError,
    UnserializeFailedError
};
use Throwable;

use function get_debug_type;
use function gettype;
use function serialize;
use function settype;
use function unserialize;

/**
 * ### Low-level data operations proxy
 *
 * Provides thin static wrappers over PHP's basic data introspection and manipulation functions.  This class is
 * low-level: no domain logic or validation rules, only raw data operations.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Data extends LowLevel {

    /**
     * ### Gets the type name of a variable in a way that is suitable for debugging
     *
     * - null
     * - bool
     * - int
     * - float
     * - string
     * - array
     * - resource (stream)
     * - resource (closed)
     * - stdClass
     * - class(at)anonymous
     * @since 1.0.0
     *
     * @param mixed $value <p>
     * The variable being type-checked.
     * </p>
     *
     * @return string Type name.
     */
    public static function getDebugType (mixed $value):string {

        return get_debug_type($value);

    }

    /**
     * ### Gets data type
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_BOOL As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_INT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_FLOAT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_STRING As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_ARRAY As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_OBJECT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_NULL As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_RESOURCE As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_CLOSED_RESOURCE As a data type.
     *
     * @param mixed $value <p>
     * The variable being type-checked.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError If a type of value is unknown.
     *
     * @return \FireHub\Core\Shared\Enums\Data\Type::* Type of data.
     */
    public static function getType (mixed $value):Type {

        return match (gettype($value)) {
            'boolean' => Type::T_BOOL,
            'integer' => Type::T_INT,
            'double' => Type::T_FLOAT,
            'string' => Type::T_STRING,
            'array' => Type::T_ARRAY,
            'object' => Type::T_OBJECT,
            'NULL' => Type::T_NULL,
            'resource' => Type::T_RESOURCE,
            'resource (closed)' => Type::T_CLOSED_RESOURCE,
            default => throw new TypeUnknownError
        };

    }

    /**
     * ### Sets data type
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\Data::getType() To get the $value type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_BOOL As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_INT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_FLOAT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_STRING As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_ARRAY As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_OBJECT As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_NULL As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_RESOURCE As a data type.
     * @uses \FireHub\Core\Shared\Enums\Data\Type::T_CLOSED_RESOURCE As a data type.
     *
     * @param mixed $value <p>
     * The variable being converted to type.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Data\Type $type <p>
     * Type to convert variable to.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\TypeUnknownError If a type of value is unknown.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\ArrayToStringConversionError If trying to convert an array to
     * string.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\FailedToSetTypeError If failed to set a type for value.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\SetAsResourceError If trying to set a resource as a type.
     *
     * @return (
     *  $type is Type::T_ARRAY
     *  ? array<array-key, mixed>
     *  : ($type is Type::T_STRING
     *    ? string
     *    : ($type is Type::T_INT
     *      ? int
     *      : ($type is Type::T_FLOAT
     *        ? float
     *        : ($type is Type::T_OBJECT
     *          ? object
     *          : ($type is Type::T_BOOL
     *            ? bool
     *            : ($type is Type::T_NULL
     *              ? null
     *              : ($type is Type::T_RESOURCE
     *                ? false
     *                : mixed)))))))
     * ) Converted value.
     */
    public static function setType (mixed $value, Type $type):mixed {

        self::getType($value) === Type::T_ARRAY && $type === Type::T_STRING
            ? throw new ArrayToStringConversionError
            : (settype($value, match ($type) {
                Type::T_BOOL => 'boolean',
                Type::T_INT => 'integer',
                Type::T_FLOAT => 'double',
                Type::T_STRING => 'string',
                Type::T_ARRAY => 'array',
                Type::T_OBJECT => 'object',
                Type::T_NULL => 'null',
                Type::T_RESOURCE, Type::T_CLOSED_RESOURCE => throw new SetAsResourceError
            }) ?: throw new FailedToSetTypeError);

        return $value;

    }

    /**
     * ### Generates storable representation of data
     *
     * Generates a storable representation of a value.<br>
     * This is useful for storing or passing PHP values around without losing their type and structure.
     * To make the serialized string into a PHP value again, use Data::unserialize().
     * @since 1.0.0
     *
     * @param null|scalar|array<array-key, mixed>|object $value <p>
     * The value is to be serialized.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\CannotSerializeError If try to serialize an anonymous class,
     * function, or resource.
     *
     * @return string String containing a byte-stream representation of a value that can be stored anywhere.
     *
     * @warning When Data::serialize() serializes objects, the leading backslash is not included in the class name
     * of namespaced classes for maximum compatibility.
     * @note This is a binary string that may include null bytes and needs to be stored and handled as such.
     * For example, Data::serialize() output should generally be stored in a BLOB field in a database, rather than
     * a CHAR or TEXT field.
     */
    public static function serialize (null|string|int|float|bool|array|object $value):string {

        try {

            return serialize($value);

        } catch (Throwable $error) {

            throw new CannotSerializeError(previous: $error);

        }

    }

    /**
     * ### Creates a PHP value from a stored representation
     * @since 1.0.0
     *
     * @param non-empty-string $data <p>
     * The serialized string.
     * </p>
     * @param bool|class-string[] $allowed_classes [optional] <p>
     * Either an array of class names which should be accepted, false to accept no classes, or true to accept all
     * classes.
     * </p>
     * @param int $max_depth [optional] <p>
     * The maximum depth of structures is permitted during unserialization and is intended to prevent stack overflows.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Data\UnserializeFailedError If couldn't unserialize data, $data is
     * already false, or $data is NULL.
     *
     * @return mixed The converted value is returned.
     */
    public static function unserialize (string $data, bool|array $allowed_classes = false, int $max_depth = 4096):mixed {

        if ($data === 'b:0;' || $data === 'N;') throw new UnserializeFailedError;

        return ($unserialized_data = unserialize(
            $data,
            ['allowed_classes' => $allowed_classes, 'max_depth' => $max_depth])
        ) !== false
            ? $unserialized_data
            : throw new UnserializeFailedError;

    }

}