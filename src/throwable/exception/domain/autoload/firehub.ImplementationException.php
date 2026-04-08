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

namespace FireHub\Core\Throwable\Exception\Domain\Autoload;

use FireHub\Core\Throwable\Exception;
use FireHub\Core\Support\LowLevel\StrSB;

/**
 * ### Autoload implementation exception
 * @since 1.0.0
 */
class ImplementationException extends Exception {

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'Autoload implementation exception.';

    /**
     * ### Autoload implementation not found
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::format() To format the exception message.
     *
     * @param string $name <p>
     * Autoload implementation name.
     * </p>
     *
     * @return self This exception.
     */
    public static function notFound (string $name):self {

        return new self(StrSB::format(
            'Autoload implementation %s not found.',
            $name
        ));

    }

}