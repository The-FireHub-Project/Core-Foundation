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

namespace FireHub\Core\Throwable\Exception\Support\Bootstrap;

use FireHub\Core\Throwable\Exception;

/**
 * ### Failed zo load bootloader exception
 * @since 1.0.0
 */
class FailedToLoadBootloaderException extends Exception {

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'Failed to load bootloader.';

}