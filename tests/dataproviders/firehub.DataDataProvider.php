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

use FireHub\Core\Shared\Enums\Data\Type;
use Countable;

/**
 * ### Data data provider
 * @since 1.0.0
 */
final class DataDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<array<string, \FireHub\Core\Shared\Enums\Data\Type::T_STRING>>
     */
    public static function string ():array {

        return [
            ['firehub', Type::T_STRING],
            ['', Type::T_STRING]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<int, \FireHub\Core\Shared\Enums\Data\Type::T_INT>>
     */
    public static function int ():array {

        return [
            [10, Type::T_INT],
            [-5, Type::T_INT],
            [0, Type::T_INT]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<float, \FireHub\Core\Shared\Enums\Data\Type::T_FLOAT>>
     */
    public static function float ():array {

        return [
            [10.5, Type::T_FLOAT],
            [-2.3, Type::T_FLOAT]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<array, \FireHub\Core\Shared\Enums\Data\Type::T_ARRAY>>
     */
    public static function array ():array {

        return [
            [[1, 2, 3], Type::T_ARRAY],
            [[1 => 'one', 2 => 'two', 3 => 'three'], Type::T_ARRAY]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<null, \FireHub\Core\Shared\Enums\Data\Type::T_NULL>>
     */
    public static function null ():array {

        return [
            [null, Type::T_NULL]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<bool, \FireHub\Core\Shared\Enums\Data\Type::T_BOOL>>
     */
    public static function bool ():array {

        return [
            [true, Type::T_BOOL],
            [false, Type::T_BOOL]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<callable, \FireHub\Core\Shared\Enums\Data\Type::T_OBJECT>>
     */
    public static function callable ():array {

        return [
            [fn() => true, Type::T_OBJECT],
            [new class {public function __invoke () {}}, Type::T_OBJECT]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<Countable, \FireHub\Core\Shared\Enums\Data\Type::T_OBJECT>>
     */
    public static function countable ():array {

        return [
            [new class implements Countable {public function count ():int {return 10;}}, Type::T_OBJECT]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<resource, \FireHub\Core\Shared\Enums\Data\Type::T_RESOURCE>>
     */
    public static function resource ():array {

        return [
            [fopen('php://stdout', 'wb'), Type::T_RESOURCE]
        ];

    }

    /**
     * @since 1.0.0
     *
     * @return array<array<resource, \FireHub\Core\Shared\Enums\Data\Type::T_CLOSED_RESOURCE>>
     */
    public static function closedResource ():array {

        $resource = fopen('php://stdout', 'wb');
        fclose($resource);

        return [
            [$resource, Type::T_CLOSED_RESOURCE]
        ];

    }

}