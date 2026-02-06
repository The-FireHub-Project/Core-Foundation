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

use FireHub\Core\Shared\Contracts\Throwable as ThrowableContract;
use Exception as InternalException;

/**
 * ### Exception throwable contract
 *
 * Represents a recoverable or expected exceptional condition within the FireHub framework.
 * @since 1.0.0
 */
class Exception extends InternalException implements ThrowableContract {

    /**
     * ### Throwable trait
     * @since 1.0.0
     */
    use Throwable;

    /**
     * ### Default exception message
     * @since 1.0.0
     *
     * @var string
     */
    protected const string DEFAULT_MESSAGE = 'General exception.';

}