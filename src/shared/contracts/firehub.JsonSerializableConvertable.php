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
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Contracts;

use FireHub\Core\Shared\Enums\Json\ {
    Flag, Flag\Decode
};

/**
 * ### JsonSerializable-convertable object that can be created from and converted to JSON
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \FireHub\Core\Shared\Contracts\JsonSerializable<TKey, TValue>
 */
interface JsonSerializableConvertable extends JsonSerializable {

    /**
     * ### Get object from JSON
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Json\Flag As parameter.
     * @uses \FireHub\Core\Shared\Enums\Json\Flag\Decode As parameter.
     *
     * @param string $json <p>
     * The JSON string being decoded.
     * </p>
     * @param positive-int $depth [optional] <p>
     * Set the maximum depth.
     * </p>
     * @param \FireHub\Core\Shared\Enums\Json\Flag|\FireHub\Core\Shared\Enums\Json\Flag\Decode ...$flags <p>
     * JSON flags.
     * </p>
     *
     * @return static This object from JSON encoded parameter.
     */
    public static function fromJson (string $json, int $depth = 512, Flag|Decode ...$flags):static;

}