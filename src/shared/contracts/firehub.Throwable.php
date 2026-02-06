<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Contracts;

use FireHub\Core\Shared\Contracts\Magic\Stringable;
use Throwable as InternalThrowable;

/**
 * ### Throwable contract
 *
 * Framework-wide throwable for all objects that can be thrown and handled as errors or exceptions within the FireHub
 * ecosystem.
 * @since 1.0.0
 */
interface Throwable extends InternalThrowable, Stringable {

    /**
     * ### Gets the throwable message
     * @since 1.0.0
     *
     * @return string The message associated with the thrown object.
     */
    public function getMessage ():string;

    /**
     * ### Gets the throwable code
     * @since 1.0.0
     *
     * @return non-negative-int The code associated with the thrown object.
     */
    public function getCode ();

    /**
     * ### Gets the file where the throwable was created
     * @since 1.0.0
     *
     * @return string The filename where the throwable was created.
     */
    public function getFile ():string;

    /**
     * ### Gets the line where the throwable was created
     * @since 1.0.0
     *
     * @return int The line number where the throwable was created.
     */
    public function getLine ():int;

    /**
     * ### Gets the stack trace as an array
     *
     * @since 1.0.0
     *
     * @return list<array{function: string, line?: int, file?: string, class?: class-string, type?: '->'|'::', args?: list<mixed>, object?: object}>
     * The stack trace represented as an array.
     */
    public function getTrace ():array;

    /**
     * ### Gets the stack trace as a string
     * @since 1.0.0
     *
     * @return string The stack trace represented as a string.
     */
    public function getTraceAsString ():string;

    /**
     * ### Gets the previous throwable in the chain
     * @since 1.0.0
     *
     * @return null|InternalThrowable The previous throwable if available, otherwise null.
     */
    public function getPrevious ():?InternalThrowable;

    /**
     * ### Gets a string representation of the throwable object
     * @since 1.0.0
     *
     * @return string The string representation of the throwable.
     */
    public function __toString ():string;

}