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

namespace FireHub\Core\Throwable\Error\LowLevel\FileSystem;

use FireHub\Core\Throwable\Error;

/**
 * ### Create link error
 * @since 1.0.0
 */
class CreateLinkError extends Error {

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'Create link error.';

}