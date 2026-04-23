<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Shared
 */

namespace FireHub\Core\Shared\Contracts;

use FireHub\Core\Shared\Enums\Json\ {
    Flag, Flag\Encode
};
use JsonSerializable as InternalJsonSerializable;

/**
 * ### JsonSerializable contract
 *
 * Objects implementing JsonSerializable can customize their JSON representation when encoded with json_encode()
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 */
interface JsonSerializable extends InternalJsonSerializable {

    /**
     * ### JSON representation of an object
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Json\Flag As parameter.
     * @uses \FireHub\Core\Shared\Enums\Json\Flag\Encode As parameter.
     *
     * @param positive-int $depth <p>
     * Set the maximum depth.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Json\Flag|\FireHub\Core\Shared\Enums\Json\Flag\Encode ...$flags <p>
     * JSON flags.
     * </p>
     *
     * @return non-empty-string JSON encoded string.
     */
    public function toJson (int $depth = 512, Flag|Encode ...$flags):string;

    /**
     * ### Specify data which should be serialized to JSON
     *
     * Serializes the object to a value that can be serialized natively by json_encode().
     * @since 1.0.0
     *
     * @return array<TKey, TValue> Data which can be serialized by json_encode(), which is a value of any type
     * other than a resource.
     */
    public function jsonSerialize ():array;

}