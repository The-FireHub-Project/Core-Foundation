<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Domain
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Domain\Autoload;

use FireHub\Core\Shared\ValueObject;
use FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidAutoloadHandleException;

/**
 * ### Autoload Handle Value Object
 *
 * Represents a registered autoloader within the FireHub Core framework.
 * This value object encapsulates the identity of a loader and provides immutability, ensuring that once created, the
 * reference cannot be altered.<br>
 * It is used by runtime support classes (e.g., `FireHub\Core\Support\Autoload`) to safely register, unregister, and
 * track autoloader implementations in a type-safe and domain-consistent manner.
 * @since 1.0.0
 *
 * @template TValue of non-empty-string $name
 *
 * @extends \FireHub\Core\Shared\ValueObject<TValue>
 */
final readonly class Handle extends ValueObject {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param TValue $name <p>
     * Handle name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidAutoloadHandleException If the handle name is
     * empty.
     *
     * @return void
     */
    public function __construct (
        private string $name
    ) {

        if ($this->name === '') throw InvalidAutoloadHandleException::empty();

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function value ():string {

        return $this->name;

    }

}