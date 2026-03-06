<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\Bootstrap\Bootloader;

use FireHub\Core\Support\Bootstrap\Bootloader;
use FireHub\Core\Support\Autoload;
use FireHub\Core\Domain\Autoload\Handle;
use FireHub\Core\Support\Autoload\Loader\Resolver;

/**
 * ### Framework Autoloaders Registration
 *
 * Responsible for registering all autoloaders required by the FireHub runtime.
 * @since 1.0.0
 *
 * @internal
 */
final class RegisterAutoloaders implements Bootloader {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\Autoload\Autoload::prepend() To prepend a new autoloader.
     * @uses \FireHub\Core\Support\Autoload\Autoload::unregister() To unregister a preloaded autoloader.
     * @uses \FireHub\Core\Support\Autoload\Loader\Resolver::addNamespace() To register a new namespace.
     * @uses \FireHub\Core\Domain\Autoload\Handle As autoloader handle.
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError If failed to register a callback
     * function as an autoloader.
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidFolderException If folder us empty.
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidNamespaceException If namespace us empty.
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException If the implementation
     * doesn't exist.
     */
    public function boot ():bool {

        $loader = new Resolver('firehub.');
        $loader->addNamespace(
            'FireHub\Core\\',
            __DIR__.'/../../../'
        );
        Autoload::prepend(new Handle('FireHub_Resolver'), $loader);

        Autoload::unregister(new Handle('FireHub_Preloader'));

        return true;

    }

}