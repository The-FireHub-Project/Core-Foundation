<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\Data\ResourceType;

use function get_resource_id;
use function get_resource_type;
use function get_resources;

/**
 * ### Low-level resource management helper
 *
 * Provides a set of low-level utility functions to inspect and manage PHP resources.
 * Includes functionality to get a resource's ID, determine its type, and retrieve collections of resources currently
 * in use.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Resources extends LowLevel {

    /**
     * ### Returns an integer identifier for the given resource
     *
     * This function provides a type-safe way of generating the integer identifier for a resource.
     * @since 1.0.0
     *
     * @param resource $resource <p>
     * The evaluated resource handle.
     * </p>
     *
     * @return positive-int The identifier for the given resource.
     */
    public static function id (mixed $resource):int {

        /** @var positive-int */
        return get_resource_id($resource);

    }

    /**
     * ### Gets the resource type
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Data\ResourceType As return.
     * @uses \FireHub\Core\Shared\Enums\Data\ResourceType::UNKNOWN If the resource type is unknown.
     *
     * @param resource $resource <p>
     * The evaluated resource handle.
     * </p>
     *
     * @return \FireHub\Core\Shared\Enums\Data\ResourceType Resource type or null if is not a resource.
     */
    public static function type (mixed $resource):ResourceType {

        return ResourceType::tryFrom(get_resource_type($resource)) ?? ResourceType::UNKNOWN;

    }

    /**
     * ### Get active resources
     *
     * Returns an array of all currently active resources, optionally filtered by resource type.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Data\ResourceType As parameter and return type.
     * @uses \FireHub\Core\Shared\Enums\Data\ResourceType::UNKNOWN If the resource type is unknown.
     * @uses \FireHub\Core\Support\LowLevel\Arr::map() To transform the array of resource identifiers into an array
     * of resource types.
     *
     * @param null|\FireHub\Core\Shared\Enums\Data\ResourceType $type [optional] <p>
     * If defined, this will cause the method to only return resources of the given type.
     * </p>
     *
     * @return array<int, \FireHub\Core\Shared\Enums\Data\ResourceType> Resource type or null if is not a resource.
     */
    public static function active (?ResourceType $type = null):array {

        return Arr::map(
            get_resources($type?->value),
            static fn($value) => ResourceType::tryFrom(get_resource_type($value)) ?? ResourceType::UNKNOWN,
        );

    }

}