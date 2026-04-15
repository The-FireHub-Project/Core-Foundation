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

namespace FireHub\Core\Support\DataStructure;

use FireHub\Core\Support\DataStructure\Builder\SequenceBuilder;

/**
 * ### Core Data Structure Abstraction Layer
 *
 * Defines the fundamental abstraction for all data structures in the FireHub ecosystem. It provides a unified
 * foundation for representing and working with different structural types such as collections, records, streams, and
 * hierarchical models, ensuring consistent behavior, type safety, and interchangeable storage implementations across
 * the system.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
final class DS {

    /**
     * ### Sequence Builder
     *
     * Creates a builder for constructing linear sequence structures.
     * @since 1.0.0
     *
     * @return \FireHub\Core\Support\DataStructure\Builder\SequenceBuilder The builder instance.
     */
    public static function sequence ():SequenceBuilder {

        return new SequenceBuilder();

    }

}