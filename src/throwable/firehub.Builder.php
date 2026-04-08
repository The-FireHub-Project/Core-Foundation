<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Throwable
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Throwable;

use FireHub\Core\Shared\Contracts\Throwable;
use FireHub\Core\Throwable\ValueObject\Code;
use Throwable as InternalThrowable;

/**
 * ### Abstract Fluent Builder
 *
 * Provides a foundational fluent construction mechanism for immutable objects within the FireHub framework.
 * @since 1.0.0
 *
 * @template TThrowable of \FireHub\Core\Shared\Contracts\Throwable
 */
abstract class Builder {

    /**
     * ### The throwable message to throw
     * @since 1.0.0
     *
     * @var string
     */
    final protected string $message = '';

    /**
     * ### The throwable code
     * @since 1.0.0
     *
     * @var null|\FireHub\Core\Throwable\ValueObject\Code<covariant non-negative-int>
     */
    final protected ?Code $code = null;

    /**
     * ### Structured, machine-readable metadata associated with the throwable instance
     * @since 1.0.0
     *
     * @var array<non-empty-string, mixed>
     */
    final protected array $context = [];

    /**
     * ### The previous throwable used for the throwable chaining
     * @since 1.0.0
     *
     * @var null|Throwable
     */
    final protected ?InternalThrowable $previous = null;

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param class-string<TThrowable> $exception <p>
     * The throwable class to throw.
     * </p>
     *
     * @return void
     */
    final public function __construct(
        final protected string $exception
    ) {}

    /**
     * ### Set the throwable message
     * @since 1.0.0
     *
     * @param string $message <p>
     * The throwable message to set.
     * </p>
     *
     * @return $this
     */
    final public function withMessage (string $message):self {

        $this->message = $message;

        return $this;

    }

    /**
     * ### Set the throwable code
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Throwable\ValueObject\Code As a parameter.
     *
     * @param \FireHub\Core\Throwable\ValueObject\Code<covariant non-negative-int> $code <p>
     * The throwable code to set.
     * </p>
     *
     * @return $this
     */
    final public function withCode (Code $code):self {

        $this->code = $code;

        return $this;

    }

    /**
     * ### Set the metadata associated with the throwable instance
     * @since 1.0.0
     *
     * @param array<non-empty-string, mixed> $context <p>
     * The metadata associated with the throwable instance to set.
     * </p>
     *
     * @return $this
     */
    final public function withContext (array $context):self {

        $this->context = $context;

        return $this;

    }

    /**
     * ### Set the previous throwable used for the throwable chaining
     * @since 1.0.0
     *
     * @param Throwable $previous <p>
     * The previous throwable used for the throwable chaining to set.
     * </p>
     *
     * @return $this
     */
    final public function withPrevious (InternalThrowable $previous):self {

        $this->previous = $previous;

        return $this;

    }

    /**
     * ### Build the Throwable object
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Contracts\Throwable To build the object.
     *
     * @return TThrowable The built object.
     */
    public function build ():Throwable {

        return new $this->exception(
            $this->message,
            $this->code,
            $this->context,
            $this->previous
        );

    }

}