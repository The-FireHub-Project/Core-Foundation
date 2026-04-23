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

namespace FireHub\Core\Support\Contracts;

/**
 * ### Data structure Contract
 *
 * Defines a generic, type-safe contract for all high-level data structures in FireHub.<br>
 * Supports iteration, array conversion, serialization, and common utility operations, ensuring consistency across
 * collections, lazy collections, and other linear or dynamic data containers.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface DataStructure {}