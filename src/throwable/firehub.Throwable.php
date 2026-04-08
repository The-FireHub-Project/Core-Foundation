<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.3
 * @package Core\Throwable
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Throwable;

use FireHub\Core\Throwable\ValueObject\Code;
use Throwable as InternalThrowable;

/**
 * ### Throwable trait
 *
 * Provides reusable functionality for framework throwable objects, including message manipulation, and code assignment.
 * @since 1.0.0
 */
trait Throwable {

    /**
     * ### Default error code
     * @since 1.0.0
     *
     * @var non-negative-int
     */
    protected const int DEFAULT_CODE = 0;

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Throwable\ValueObject\Code::value() To get the code raw value.
     * @uses static::DEFAULT_MESSAGE As a default throwable message.
     * @uses \FireHub\Core\Throwable\Throwable::DEFAULT_CODE As a default throwable error code.
     *
     * @param string $message [optional] <p>
     * The throwable message to throw.<br>
     * If a message is empty, the default throwable message will be shown.
     * </p>
     * @param null|\FireHub\Core\Throwable\ValueObject\Code<covariant non-negative-int> $code [optional] <p>
     * The throwable code.
     * </p>
     * @param array<non-empty-string, mixed> $context [optional] <p>
     * Holds structured, machine-readable metadata associated with the throwable instance.<br>
     * Context data is intended for logging, debugging, monitoring, and transport layers, and must not replace the
     * human-readable exception message.<br>
     * Keys must be non-empty strings to ensure predictable normalization and serialization.
     * </p>
     * @param null|InternalThrowable $previous [optional] <p>
     * The previous throwable used for the throwable chaining.
     * </p>
     *
     * @return void
     */
    final public function __construct (
        string $message = '',
        ?Code $code = null,
        protected array $context = [],
        ?InternalThrowable $previous = null
    ) {

        parent::__construct(
            $message !== '' ? $message : static::DEFAULT_MESSAGE,
            $code?->value() ?? static::DEFAULT_CODE,
            $previous
        );

    }

    /**
     * ### Static typed builder factory
     * @since 1.0.0
     *
     * @return \FireHub\Core\Throwable\Builder<static> Abstract Fluent Builder.
     */
    abstract public static function builder():Builder;

    /**
     * ### Gets the metadata associated with the throwable instance
     * @since 1.0.0
     *
     * @return array<non-empty-string, mixed> The metadata associated with the throwable instance.
     */
    final public function getContext ():array {

        return $this->context;

    }

}