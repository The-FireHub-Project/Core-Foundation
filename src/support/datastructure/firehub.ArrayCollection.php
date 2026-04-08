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
 */

namespace FireHub\Core\Support\DataStructure;

use FireHub\Core\Support\DataStructure\Abstract\ArrayCollection as AbstractArrayCollection;

/**
 * ### Concrete Array-Based Collection Implementation
 *
 * Represents a concrete collection implementation backed by a native array, providing a general-purpose, ready-to-use
 * data structure with full support for collection operations.
 *
 * It extends the abstract array-backed base and exposes a complete, consistent API for working with ordered or
 * key-based data, making it the default implementation for most use cases within the FireHub framework.
 * @since 1.0.0
 *
 * @template TKey of array-key
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Abstract\ArrayCollection<TKey, TValue>
 */
class ArrayCollection extends AbstractArrayCollection {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param array<TKey, TValue> $storage [optional] <p>
     * Underlying storage data.
     * </p>
     *
     * @retrun void
     */
    final public function __construct (
        array $storage = []
    ) {

        parent::__construct($storage);

    }

    /**
     * {@inheritDoc}
     *
     * <code>
     * use FireHub\Core\Support\DataStructures\ArrayCollection;
     *
     * $collection = ArrayCollection::fromArray(['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]);
     *
     * // ['firstname' => 'John', 'lastname' => 'Doe', 'age' => 25, 10 => 2]
     * </code>
     *
     * @since 1.0.0
     *
     * @template TArray of array<array-key, mixed>
     *
     * @param TArray $array <p>
     * Input data for creating the object.
     * </p>
     *
     * @return static<key-of<TArray>, value-of<TArray>> A new instance of the implementing class.
     */
    public static function fromArray (array $array):static {

        return new static($array);

    }

}