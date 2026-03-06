<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.2
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support;

use FireHub\Core\Support\Autoload\Loader;
use FireHub\Core\Domain\Autoload\Handle;
use FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException;
use FireHub\Core\Support\LowLevel\SplAutoload;

/**
 * ### Handles dynamic class autoloading within the FireHub Core framework
 *
 * This class manages the registration, invocation, and tracking of autoload functions, enabling seamless loading of
 * PHP classes on-demand without manual `require` or `include` statements. It serves as the central mechanism for
 * automatic class resolution in the framework.
 * @since 1.0.0
 */
final class Autoload {

    /**
     * ### Autoload function registry
     * @since 1.0.0
     *
     * @var array<non-empty-string, \FireHub\Core\Support\Autoload\Loader>
     */
    private static array $registry = [];

    /**
     * ### Protected and final constructor to prevent instantiation and overriding
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Domain\Autoload\Handle The handle parameter for the autoload function.
     * @uses \FireHub\Core\Support\Autoload\Loader The loader parameter for the autoload function.
     * @uses SplAutoload::register() To register the autoload function.
     *
     * @param \FireHub\Core\Domain\Autoload\Handle<covariant non-empty-string> $handle <p>
     * Handle being used to load a class.
     * </p>
     * @param \FireHub\Core\Support\Autoload\Loader $loader <p>
     * Loader being used to find a class path.
     * </p>
     * @param bool $prepend <p>
     * Whether to prepend the autoload function or not.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError If failed to register a callback
     * function as an autoloader.
     *
     * @return void
     */
    private function __construct(
        private readonly Handle $handle,
        private readonly Loader $loader,
        private readonly bool $prepend
    ) {

        SplAutoload::register($this->loader, $this->prepend);

        self::$registry[$this->handle->value()] = $this->loader;

    }

    /**
     * ### Register a new autoloaded implementation at the end of the queue
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Domain\Autoload\Handle The handle parameter for the autoload function.
     * @uses \FireHub\Core\Support\Autoload\Loader The loader parameter for the autoload function.
     *
     * @param \FireHub\Core\Domain\Autoload\Handle<covariant non-empty-string> $handle <p>
     * Handle being used to load a class.
     * </p>
     * @param \FireHub\Core\Support\Autoload\Loader $loader <p>
     * Loader being used to find a class path.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError If failed to register a callback
     * function as an autoloader.
     *
     * @return self New autoload implementation.
     */
    public static function append (Handle $handle, Loader $loader):self {

        return new self($handle, $loader, false);

    }

    /**
     * ### Register a new autoloaded implementation at the beginning of the queue
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Domain\Autoload\Handle The handle parameter for the autoload function.
     * @uses \FireHub\Core\Support\Autoload\Loader The loader parameter for the autoload function.
     *
     * @param \FireHub\Core\Domain\Autoload\Handle<covariant non-empty-string> $handle <p>
     * Handle being used to load a class.
     * </p>
     * @param \FireHub\Core\Support\Autoload\Loader $loader <p>
     * Loader being used to find a class path.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError If failed to register a callback
     * function as an autoloader.
     *
     * @return self New autoload implementation.
     */
    public static function prepend (Handle $handle, Loader $loader):self {

        return new self($handle, $loader, true);

    }

    /**
     * ### Register a new autoloaded implementation at the end of the queue
     * @since 1.0.0
     *
     * @see \FireHub\Core\Support\Autoload::prepend()
     *
     * @uses \FireHub\Core\Domain\Autoload\Handle The handle parameter for the autoload function.
     * @uses \FireHub\Core\Support\Autoload\Loader The loader parameter for the autoload function.
     * @uses \FireHub\Core\Support\Autoload::append() To register a new autoloaded implementation at
     * the end of the queue.
     *
     * @param \FireHub\Core\Domain\Autoload\Handle<covariant non-empty-string> $handle <p>
     * Handle being used to load a class.
     * </p>
     * @param \FireHub\Core\Support\Autoload\Loader $loader <p>
     * Loader being used to find a class path.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\RegisterAutoloadError If failed to register a callback
     * function as an autoloader.
     *
     * @return self New autoload implementation.
     *
     * @note This method is an alias for Autoload#append().
     */
    public static function register (Handle $handle, Loader $loader):self {

        return self::append($handle, $loader);

    }

    /**
     * ### Unregister autoload implementation
     *
     * Removes a function from the autoloaded queue.<br>
     * If the queue is activated and empty after removing the given function, then it will be deactivated.<br>
     * When this function results in the queue being deactivated, any autoload function that previously existed will
     * not be reactivated.
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Domain\Autoload\Handle The handle parameter for the autoload function.
     * @uses \FireHub\Core\Support\LowLevel\SplAutoload::unregister() To unregister the autoload function.
     *
     * @param \FireHub\Core\Domain\Autoload\Handle<covariant non-empty-string> $handle <p>
     * Handle being used to load a class.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\ImplementationException If the implementation
     * doesn't exist.
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Arr\UnregisterAutoloaderError If failed to unregister
     * autoloader implementation.
     *
     * @return true True if autoloader was unregistered.
     */
    public static function unregister (Handle $handle):true {

        $key = $handle->value();

        if (!isset(self::$registry[$key]))
            throw ImplementationException::notFound($key);

        SplAutoload::unregister(self::$registry[$key]);

        unset(self::$registry[$key]);

        return true;

    }

    /**
     * ### Get all registered autoloader implementations
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\SplAutoload::functions() To ge the list of all registered autoloader
     * implementations.
     *
     * @return list<mixed> An array of all registered autoload functions, or if no function is registered,
     * or autoloaded queue is not activated; then the return value will be an empty array.
     */
    public static function implementations ():array {

        return SplAutoload::functions();

    }

}