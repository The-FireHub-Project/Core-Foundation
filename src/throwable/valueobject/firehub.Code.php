<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Throwable
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Throwable\ValueObject;

use FireHub\Core\Shared\ValueObject;

/**
 * ### Error code value object
 * @since 1.0.0
 *
 * @template TValue of int
 *
 * @extends \FireHub\Core\Shared\ValueObject<TValue>
 */
final readonly class Code extends ValueObject {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\ValueObject::guard() As a guard.
     *
     * @param TValue $code <p>
     * The error code.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\InvalidValueObjectError If the code is negative.
     *
     * @return void
     */
    public function __construct (
        private int $code
    ) {

        $this->guard(fn() => $code < 0, 'Error code int must be non-negative.');

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function value ():int {

        return $this->code;

    }

}