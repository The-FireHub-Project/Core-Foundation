<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Throwable\Error\LowLevel\Func\RegisterTickFailedError;

use function call_user_func;
use function call_user_func_array;
use function function_exists;
use function register_shutdown_function;
use function register_tick_function;
use function unregister_tick_function;

/**
 * ### Func low-level proxy class
 *
 * Provides a set of low-level, fail-fast helpers for working with PHP functions.<br>
 * This class offers type-safe methods for dynamically calling functions, checking function existence, and
 * registering shutdown or tick callbacks.<br>
 * It is intended for internal/core use, enabling predictable and consistent runtime behavior when dealing with
 * functions.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class Func extends LowLevel {

    /**
     * ### Checks if the function name exists
     *
     * Checks the list of defined functions, both built-in (internal) and user-defined, for function.
     * @since 1.0.0
     *
     * @param non-empty-string $name <p>
     * The function name.
     * </p>
     *
     * @phpstan-assert-if-true callable-string $name
     * @phpstan-assert-if-false !callable-string $name
     *
     * @return bool True if the interface exists, false otherwise.
     *
     * @note This function will return false for constructs, such as include_once and echo.
     * @note A function name may exist even if the function itself is unusable due to configuration or compiling
     * options.
     */
    public static function isFunction (string $name):bool {

        return function_exists($name);

    }

    /**
     * ### Call the callback
     *
     * Calls the callback given by the first parameter and passes the remaining parameters as arguments.
     * @since 1.0.0
     *
     * @template TReturn
     * @template TParameters
     *
     * @param callable(TParameters...):TReturn $callback <p>
     * The callable to be called.
     * </p>
     * @param TParameters ...$arguments <p>
     * Zero or more parameters to be passed to the callback.
     * </p>
     *
     * @return TReturn The return value of the callback.
     *
     * @note Callbacks registered with this method will not be called if there is an uncaught exception thrown
     * in a previous callback.
     */
    public static function call (callable $callback, mixed ...$arguments):mixed {

        return call_user_func($callback, ...$arguments);

    }

    /**
     * ### Call the callback with an array of parameters
     *
     * Calls the callback given by the first parameter with the parameters in $arguments.
     * @since 1.0.0
     *
     * @template TReturn
     * @template TParameters
     *
     * @param callable(TParameters...):TReturn $callback <p>
     * The callable to be called.
     * </p>
     * @param array<TParameters> $arguments <p>
     * The parameters that are to be passed to the function as an indexed array.
     * </p>
     *
     * @return TReturn The return value of the callback.
     *
     * @note Callbacks registered with this method will not be called if there is an uncaught exception thrown
     * in a previous callback.
     */
    public static function callWithArray (callable $callback, array $arguments):mixed {

        return call_user_func_array($callback, $arguments);

    }

    /**
     * ### Register a function for execution on shutdown
     *
     * Registers a callback to be executed after script execution finishes or exit() is called.<br>
     * Multiple calls to Func#registerShutdown() can be made, and each will be called in the same order as they
     * were registered.<br>
     * If you call exit() within one registered shutdown function, processing will stop completely and no other
     * registered shutdown functions will be called.<br>
     * Shutdown functions may also call Func#registerShutdown() themselves to add a shutdown function to the end of
     * the queue.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The shutdown callback to register.<br>
     * The shutdown callbacks are executed as part of the request, so it is possible to send output from them and
     * access output buffers.
     * </p>
     * @param mixed ...$arguments <p>
     * It is possible to pass parameters to the shutdown function by passing additional parameters.
     * </p>
     *
     * @return void
     *
     * @note The working directory of the script can change inside the shutdown function under some web servers,
     * for example, Apache.
     * @note Shutdown functions will not be executed if the process is killed with a SIGTERM or SIGKILL signal.<br>
     * While you can't intercept a SIGKILL, you can use pcntl_signal() to install a handler for a SIGTERM which uses
     * exit() to end cleanly.
     * @note Shutdown functions run separately from the time tracked by max_execution_time.<br>
     * That means even if a process is terminated for running too long, shutdown functions will still be called.<br>
     * Additionally, if the max_execution_time runs out while a shutdown function is running, it will not be terminated.
     */
    public static function registerShutdown (callable $callback, mixed ...$arguments):void {

        register_shutdown_function($callback, ...$arguments);

    }

    /**
     * ### Register a function for execution on each tick
     *
     * Registers the given callback to be executed when a tick is called.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The function to register.
     * </p>
     * @param mixed ...$arguments <p>
     * Parameters for a callback function.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\Func\RegisterTickFailedError If failed to register tick function.
     *
     * @return true True on success.
     */
    public static function registerTick (callable $callback, mixed ...$arguments):true {

        return register_tick_function($callback, ...$arguments)
            ?: throw new RegisterTickFailedError;

    }

    /**
     * ### De-register a function for execution on each tick
     *
     * De-registers the function, so it is no longer executed when a tick is called.
     * @since 1.0.0
     *
     * @param callable $callback <p>
     * The function to deregister.
     * </p>
     *
     * @return void
     */
    public static function unregisterTick (callable $callback):void {

        unregister_tick_function($callback);

    }

}