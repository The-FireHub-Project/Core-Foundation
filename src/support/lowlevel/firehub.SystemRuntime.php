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

namespace FireHub\Core\Support\LowLevel;

use FireHub\Core\Support\LowLevel;
use FireHub\Core\Shared\Enums\Comparison;
use FireHub\Core\Shared\Enums\SystemRuntime\ {
    IniAccessLevel, PhpExtension
};
use FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\ {
    FailedToGetProcessIDError, FailedToGetServerAPIError, FailedToSetConfigurationOptionError,
    InvalidConfigurationOptionError, InvalidConfigurationQuantityError, InvalidExtensionError, SleepTimeInvalidError
};

use function extension_loaded;
use function get_current_user;
use function get_extension_funcs;
use function get_included_files;
use function get_loaded_extensions;
use function getenv;
use function getmypid;
use function ini_get;
use function ini_get_all;
use function ini_parse_quantity;
use function ini_restore;
use function ini_set;
use function memory_get_peak_usage;
use function memory_get_usage;
use function memory_reset_peak_usage;
use function php_ini_loaded_file;
use function php_sapi_name;
use function php_uname;
use function phpversion;
use function putenv;
use function sleep;
use function sys_get_temp_dir;
use function usleep;
use function version_compare;
use function zend_version;

/**
 * ### System and PHP Runtime Utilities
 *
 * Provides low-level utility methods to access and manipulate PHP runtime environment, system information,
 * configuration settings, extensions, memory usage, process info, and other core runtime features.<br>
 * Designed as a lightweight, foundational helper for environment inspection and control.
 * @since 1.0.0
 *
 * @internal
 *
 * @note This class is intended only as an inheritance base for framework-internal helpers.<br>
 * Do not instantiate or extend outside the FireHub low-level helper ecosystem.
 */
final class SystemRuntime extends LowLevel {

    /**
     * ### Check if a PHP extension is loaded
     * @since 1.0.0
     *
     * @param string|\FireHub\Core\Shared\Enums\SystemRuntime\PhpExtension $name <p>
     * Extension name or verified extension enum.<br>
     * This parameter is case-insensitive for strings.
     * </p>
     *
     * @return bool True if the extension is loaded, false otherwise.
     */
    public static function isExtensionLoaded (string|PhpExtension $name):bool {

        return extension_loaded($name instanceof PhpExtension ? $name->value : $name);

    }

    /**
     * ### Array with the names of all modules compiled and loaded
     * @since 1.0.0
     *
     * @return list<non-empty-string> Indexed array of all the module names.
     */
    public static function loadedExtensions ():array {

        /** @var list<non-empty-string> */
        return get_loaded_extensions();

    }

    /**
     * ### Array with the names of the functions for a module
     * @since 1.0.0
     *
     * @param string $extension <p>
     * The module name. This parameter is case-insensitive.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError If the extension is not valid.
     *
     * @return list<non-empty-string> Array with all the functions.
     */
    public static function extensionFunctions (string $extension):array {

        return ($functions = get_extension_funcs($extension)) !== false
            ? $functions : throw new InvalidExtensionError;

    }

    /**
     * ### Array with the names of included or required files
     * @since 1.0.0
     *
     * @return list<non-empty-string> Array of the names for all files referenced by include and family.
     */
    public static function includedFiles ():array {

        /** @var list<non-empty-string> */
        return get_included_files();

    }

    /**
     * ### Gets the name of the owner for the current PHP script
     * @since 1.0.0
     *
     * @return string Username as a string.
     */
    public static function scriptOwner ():string {

        return get_current_user();

    }

    /**
     * ### Gets the value of a single or all the environment variables
     * @since 1.0.0
     *
     * @param null|string $name [optional] <p>
     * The variable name as a string or null.
     * </p>
     *
     * @return ($name is null ? array<string, string> : string|false) Returns the value of the environment variable
     * name, or false if the environment variable name doesn't exist.<br>
     * If the name is null, all environment variables are returned as an associative array.
     */
    public static function getEnvironmentVariable (?string $name = null):array|string|false {

        return getenv($name);

    }

    /**
     * ### Sets the value of an environment variable
     *
     * Adds assignment to the server environment.<br>
     * The environment variable will only exist for the duration of the current request.<br>
     * At the end of the request, the environment is restored to its original state.
     * @since 1.0.0
     *
     * @param non-empty-string $assignment <p>
     * The setting, like "FOO=BAR".
     * </p>
     *
     * @return bool True on success or false on failure.
     */
    public static function setEnvironmentVariable (string $assignment):bool {

        return putenv($assignment);

    }

    /**
     * ### Retrieve a path to the loaded php.ini file
     * @since 1.0.0
     *
     * @return non-empty-string|false The loaded php.ini path, or false if one is not loaded.
     */
    public static function getConfigurationPath ():string|false {

        return php_ini_loaded_file();

    }

    /**
     * ### Gets the value of a configuration option
     * @since 1.0.0
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationOptionError If configuration
     * option is not valid.
     *
     * @return string Value of the configuration option as a string on success, or an empty string for null
     * values.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".<br>
     * The function can also return the literal string of INI value.
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function getConfigurationOption (string $option):string {

        return ini_get($option)
            ?: throw new InvalidConfigurationOptionError;

    }

    /**
     * ### Gets all configuration options
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\SystemRuntime\IniAccessLevel To set an access level.
     * @uses \FireHub\Core\Support\LowLevel\SystemRuntime::loadedExtensions() To check if the extension is loaded.
     *
     * @param null|non-empty-string $extension <p>
     * An optional extension name.<br>
     * If not null or the string core, the function returns only options specific for that extension.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError If the extension is not valid.
     *
     * @return array<non-empty-string, array{global_value: null|int|string, local_value: null|int|string, access: \FireHub\Core\Shared\Enums\SystemRuntime\IniAccessLevel}>
     * Associative array with a directive name as the array key.
     *
     * @note Method ignores "array" ini options such as pdo.dsn.*.
     */
    public static function getConfigurationOptions (?string $extension = null):array {

        /** @var array<non-empty-string, array{
         *   global_value: null|int|string,
         *   local_value: null|int|string,
         *   access: int
         * }> $options
         */
        $options = ($extension === null || self::isExtensionLoaded($extension))
            ? ini_get_all($extension) // @phpstan-ignore varTag.nativeType
            : throw new InvalidExtensionError;

        foreach ($options as $option => $values)
            $options[$option]['access'] = IniAccessLevel::from($values['access']);

        return $options;

    }

    /**
     * ### Sets the value of a configuration option
     *
     * Sets the value of the given configuration option.<br>
     * The configuration option will keep this new value during the script's execution and will be restored at the
     * script's ending.
     * @since 1.0.0
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     * @param null|scalar $value <p>
     * The new value for the option.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToSetConfigurationOptionError If failed to
     * set configuration option.
     *
     * @return True Always true.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".<br>
     * The function can also return the literal string of INI value.<br>
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function setConfigurationOption (string $option, null|int|float|string|bool $value):true {

        return ini_set($option, $value) !== false
            ? true : throw new FailedToSetConfigurationOptionError;

    }

    /**
     * ### Restores the value of a configuration option to its original value
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\SystemRuntime::getConfigurationOption() To get the original value.
     *
     * @param non-empty-string $option <p>
     * The configuration option name.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationOptionError If configuration
     * option is not valid.
     *
     * @return string Value of the configuration option as a string on success, or an empty string for null
     * values.
     *
     * @note A boolean ini value of off will be returned as an empty string or "0" while a boolean ini value of on
     * will be returned as "1".<br>
     * The function can also return the literal string of INI value.
     * @note Method can't read array ini options such as pdo.dsn.*, and returns false in this case.
     */
    public static function restoreConfigurationOption (string $option):string {

        ini_restore($option);

        return self::getConfigurationOption($option);

    }

    /**
     * ### Get interpreted size from ini shorthand syntax
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::trim() To trim the input string.
     * @uses \FireHub\Core\Support\LowLevel\Regex::match() To validate the input string.
     *
     * @param non-empty-string $shorthand <p>
     * Ini shorthand to parse, there must be a number followed by an optional multiplier.<br>
     * The following multipliers are supported: k/K (1024), m/M (1048576), g/G (1073741824).<br>
     * The number can be a decimal, hex (prefixed with 0x or 0X), octal (prefixed with 0o, 0O, or 0) or binary
     * (prefixed with 0b or 0B).
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationQuantityError If shorthand is
     * not valid.
     *
     * @return non-negative-int Interpreted size in bytes on success from ini shorthand.
     */
    public static function parseConfigurationQuantity (string $shorthand):int {

        /** @var non-negative-int */
        return Regex::match('/^(?:0x[0-9a-fA-F]+|0b[01]+|0o[0-7]+|\d+)[KMG]?$/x', StrSB::trim($shorthand)) === false
            ? throw new InvalidConfigurationQuantityError
            : ini_parse_quantity($shorthand);

    }

    /**
     * ### Gets PHP's process ID
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetProcessIDError If failed to get a
     * process ID.
     *
     * @return positive-int Current PHP process ID.
     *
     * @warning Process IDs aren't unique, thus they're a weak entropy source.<br>
     * We recommend against relying on pids in security-dependent contexts.
     */
    public static function processID ():int {

        /** @var positive-int */
        return ($process_id = getmypid()) !== false
            ? $process_id : throw new FailedToGetProcessIDError();

    }

    /**
     * ### Type of interface between web server and PHP
     *
     * Returns a lowercase string that describes the type of interface (the Server API, SAPI) that PHP is using.<br>
     * For example, in CLI PHP this string will be "cli" whereas with Apache it may have several different values
     * depending on the exact SAPI used.
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetServerAPIError If failed to get server
     * API.
     *
     * @return non-empty-string Interface type.
     */
    public static function serverAPI ():string {

        return ($sapi_name = php_sapi_name()) !== false
            ? $sapi_name : throw new FailedToGetServerAPIError();

    }

    /**
     * ### Gets OS information
     *
     * Information about the operating system PHP is running one "cli" whereas with Apache it may have several different
     * values depending on the exact SAPI used.
     * @since 1.0.0
     *
     * @return array{name: string, hostname: string, release: string, version: string, machine: string} Operating system
     * information.
     */
    public static function osInfo ():array {

        return [
            'name' => php_uname('s'),
            'hostname' => php_uname('n'),
            'release' => php_uname('r'),
            'version' => php_uname('v'),
            'machine' => php_uname('m')
        ];

    }

    /**
     * ### Gets the current PHP or extension version
     * @since 1.0.0
     *
     * @param null|non-empty-string|\FireHub\Core\Shared\Enums\SystemRuntime\PhpExtension $extension <p>
     * An optional extension name.
     * </p>
     *
     * @return string|false The current PHP version as a string.<br>
     * If a string argument is provided for an extension parameter, phpversion() returns the version of that extension,
     * or false if there is no version information associated or the extension isn't enabled.
     */
    public static function version (null|string|PhpExtension $extension = null):string|false {

        return phpversion($extension instanceof PhpExtension ? $extension->value : $extension); // @phpstan-ignore argument.type (PHPStan reports that $name argument can't be null)

    }

    /**
     * ### Compares two "PHP-standardized" version number strings
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Shared\Enums\Comparison To set a comparison operator.
     *
     * @param string $first <p>
     * First version number.
     * </p>
     * @param string $second <p>
     * Second version number.
     * </p>
     *
     * @return ($comparison is null
     *   ? int-mask<-1, 0, 1>
     *   : ($comparison is \FireHub\Core\Shared\Enums\Comparison::SPACESHIP
     *     ? int-mask<-1, 0, 1>
     *     : bool
     * )) Returns -1 if the first version is lower than the second, 0 if they're equal, and 1 if the second is lower.
     */
    public static function compareVersion (string $first, string $second, ?Comparison $comparison = null):int|bool {

        /**
         *  @var ($comparison is null
         *   ? int-mask<-1, 0, 1>
         *   : ($comparison is \FireHub\Core\Shared\Enums\Comparison::SPACESHIP
         *     ? int-mask<-1, 0, 1>
         *     : bool
         * ))
         *
         * @phpstan-ignore-next-line
         */
        return version_compare(
            $first,
            $second,
            $comparison === Comparison::SPACESHIP || $comparison === null ? null : $comparison->value
        );

    }

    /**
     * ### Gets the version of the current Zend engine
     * @since 1.0.0
     *
     * @return non-empty-string Zend Engine version number, as a string.
     */
    public static function zendVersion ():string {

        /** @var non-empty-string */
        return zend_version();

    }

    /**
     * ### Gets a directory path used for temporary files
     * @since 1.0.0
     *
     * @return non-empty-string Path of the temporary directory.
     */
    public static function tempFolder ():string {

        /** @var non-empty-string */
        return sys_get_temp_dir();

    }

    /**
     * ### Gets the amount of memory allocated to PHP
     * @since 1.0.0
     *
     * @return non-negative-int The memory amount in bytes.
     */
    public static function getMemoryUsage ():int {

        return memory_get_usage();

    }

    /**
     * ### Gets the peak of memory allocated by PHP
     * @since 1.0.0
     *
     * @return non-negative-int The memory peak in bytes.
     */
    public static function getMemoryPeakUsage ():int {

        return memory_get_peak_usage();

    }

    /**
     * ### Reset the peak memory usage
     * @since 1.0.0
     *
     * @return void
     */
    public static function resetMemoryPeakUsage ():void {

        memory_reset_peak_usage();

    }

    /**
     * ### Delay execution
     * @since 1.0.0
     *
     * @param non-negative-int $seconds <p>
     * Halt time in seconds.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError If the sleep time is invalid.
     *
     * @return bool True on success, false if the call was interrupted by a signal.
     */
    public static function sleep (int $seconds):bool {

        return $seconds < 0
            ? throw new SleepTimeInvalidError
             : sleep($seconds) === 0;

    }

    /**
     * ### Delays program execution for the given number of microseconds
     * @since 1.0.0
     *
     * @param int<0, 999999> $microseconds <p>
     * Halt time in microseconds.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError If the number of microseconds is
     * less than 0 or more than 999_999.
     *
     * @return void
     */
    public static function microsleep (int $microseconds):void {

        if ($microseconds < 0 || $microseconds > 999_999)
            throw new SleepTimeInvalidError;

        usleep($microseconds);

    }

}