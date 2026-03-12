<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Shared\Enums\{
    Comparison, SystemRuntime\PhpExtension
};
use FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\ {
    FailedToSetConfigurationOptionError, InvalidConfigurationOptionError, InvalidConfigurationQuantityError,
    InvalidExtensionError, SleepTimeInvalidError
};
use FireHub\Core\Support\LowLevel\SystemRuntime;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Depends, Group, Small, TestWith
};

/**
 * ### Test System and PHP Runtime Utilities
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(SystemRuntime::class)]
final class SystemRuntimeTest extends Base {

    /**
     * @since 1.0.0
     *
     * @param string|\FireHub\Core\Shared\Enums\SystemRuntime\PhpExtension $name
     *
     * @return void
     */
    #[TestWith(['Core'])]
    #[TestWith([PhpExtension::CORE])]
    public function testIsExtensionLoaded (string|PhpExtension $name):void {

        self::assertTrue(SystemRuntime::isExtensionLoaded($name));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testLoadedExtensions ():void {

        self::assertIsList(SystemRuntime::loadedExtensions());

    }

    /**
     * @since 1.0.0
     *
     * @param string $extension
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError
     *
     * @return void
     */
    #[TestWith(['Core'])]
    public function testIsExtensionFunctions (string $extension):void {

        self::assertIsList(SystemRuntime::extensionFunctions($extension));

    }

    /**
     * @since 1.0.0
     *
     * @param string $extension
     *
     * @return void
     */
    #[TestWith(['NotValidExtension'])]
    public function testIsExtensionFunctionsNotValid (string $extension):void {

        $this->expectException(InvalidExtensionError::class);

        SystemRuntime::extensionFunctions($extension);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testIncludedFiles ():void {

        self::assertIsList(SystemRuntime::includedFiles());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testScriptOwner ():void {

        self::assertIsString(SystemRuntime::scriptOwner());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $assignment
     *
     * @return void
     */
    #[TestWith(['FOO=BAR'])]
    public function testSetEnvironmentVariables (string $assignment):void {

        self::assertTrue(SystemRuntime::setEnvironmentVariable($assignment));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetEnvironmentVariables ():void {

        self::assertIsArray(SystemRuntime::getEnvironmentVariable());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $name
     *
     * @return void
     */
    #[TestWith(['FOO'])]
    #[Depends('testSetEnvironmentVariables')]
    public function testGetEnvironmentVariablesWithName (string $name):void {

        self::assertSame('BAR', SystemRuntime::getEnvironmentVariable($name));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetConfigurationPath ():void {

        self::assertIsString(SystemRuntime::getConfigurationPath());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationOptionError
     *
     * @return void
     */
    #[TestWith(['post_max_size'])]
    public function testGetConfigurationOption (string $option):void {

        self::assertIsString(SystemRuntime::getConfigurationOption($option));

    }

    /**
     * @since 1.0.0
     *
     * @param string $name
     *
     * @return void
     */
    #[TestWith(['NotValidConfigurationOption'])]
    public function testGetConfigurationOptionNotValid (string $name):void {

        $this->expectException(InvalidConfigurationOptionError::class);

        SystemRuntime::getConfigurationOption($name);

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError
     *
     * @return void
     */
    public function testGetConfigurationOptions ():void {

        self::assertIsArray(SystemRuntime::getConfigurationOptions());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $extension
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidExtensionError
     *
     * @return void
     */
    #[TestWith(['pcre'])]
    public function testGetConfigurationOptionWithName (string $extension):void {

        self::assertIsArray(SystemRuntime::getConfigurationOptions($extension));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $extension
     *
     * @return void
     */
    #[TestWith(['NotValidExtension'])]
    public function testGetConfigurationOptionWithNameNotValid (string $extension):void {

        $this->expectException(InvalidExtensionError::class);

        SystemRuntime::getConfigurationOptions($extension);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     * @param null|scalar $value
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToSetConfigurationOptionError
     *
     * @return void
     */
    #[TestWith(['display_errors', '0'])]
    public function testSetConfigurationOptions (string $option, null|int|float|string|bool $value):void {

        self::assertTrue(SystemRuntime::setConfigurationOption($option, $value));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     * @param null|scalar $value
     *
     * @return void
     */
    #[TestWith(['test', '0'])]
    public function testSetConfigurationOptionsFailed (string $option, null|int|float|string|bool $value):void {

        $this->expectException(FailedToSetConfigurationOptionError::class);

        SystemRuntime::setConfigurationOption($option, $value);

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationOptionError
     *
     * @return void
     */
    #[TestWith(['max_memory_limit'])]
    public function testRestoreConfigurationOption (string $option):void {

        self::assertIsString(SystemRuntime::restoreConfigurationOption($option));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $option
     *
     * @return void
     */
    #[TestWith([''])]
    public function testRestoreConfigurationOptionWithEmptyOption (string $option):void {

        $this->expectException(InvalidConfigurationOptionError::class);

        SystemRuntime::restoreConfigurationOption($option);

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $expected
     * @param non-empty-string $shorthand
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\InvalidConfigurationQuantityError
     *
     * @return void
     */
    #[TestWith([1024, '1024'])]
    #[TestWith([1073741824, '1024M'])]
    #[TestWith([524288, '512K'])]
    #[TestWith([532, '0o1024'])]
    #[TestWith([532, '01024'])]
    public function testParseConfigurationQuantity (int $expected, string $shorthand):void {

        self::assertSame($expected, SystemRuntime::parseConfigurationQuantity($shorthand));

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $shorthand
     *
     * @return void
     */
    #[TestWith(['xxx'])]
    public function testParseConfigurationQuantityWithInvalidShorthand (string $shorthand):void {

        $this->expectException(InvalidConfigurationQuantityError::class);

        SystemRuntime::parseConfigurationQuantity($shorthand);

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetProcessIDError
     *
     * @return void
     */
    public function testProcessID ():void {

        self::assertIsInt(SystemRuntime::processID());

    }

    /**
     * @since 1.0.0
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\FailedToGetServerAPIError
     *
     * @return void
     */
    public function testServerAPI ():void {

        self::assertIsString(SystemRuntime::serverAPI());

    }

    /**
     * @since 1.0.0
     *
     * @param non-empty-string $key
     *
     * @return void
     */
    #[TestWith(['name'])]
    #[TestWith(['hostname'])]
    #[TestWith(['release'])]
    #[TestWith(['version'])]
    #[TestWith(['machine'])]
    public function testOsInfo (string $key):void {

        self::assertArrayHasKey($key, SystemRuntime::osInfo());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testVersion ():void {

        self::assertSame(SystemRuntime::version(), SystemRuntime::version('Core'));

    }

    /**
     * @since 1.0.0
     *
     * @param int-mask<-1, 0, 1>|bool $excepted
     * @param string $first
     * @param string $second
     *
     * @return void
     */
    #[TestWith([-1, '1.0.0', '1.0.1'])]
    #[TestWith([0, '1.0.0', '1.0.0'])]
    #[TestWith([1, '2.0.0', '1.0.0'])]
    #[TestWith([true, '2.0.0', '1.0.0', Comparison::GREATER])]
    #[TestWith([false, '2.0.0', '3.0.0', Comparison::GREATER])]
    public function testCompareVersion (int|bool $excepted, string $first, string $second, ?Comparison $comparison = null):void {

        self::assertSame($excepted, SystemRuntime::compareVersion($first, $second, $comparison));

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testZendVersion ():void {

        self::assertIsString(SystemRuntime::zendVersion());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testTempFolder ():void {

        self::assertIsString(SystemRuntime::tempFolder());

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetMemoryUsage ():void {

        self::assertIsInt(SystemRuntime::getMemoryUsage());
        self::assertTrue(SystemRuntime::getMemoryUsage() > 0);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testGetMemoryPeakUsage ():void {

        self::assertIsInt(SystemRuntime::getMemoryPeakUsage());
        self::assertTrue(SystemRuntime::getMemoryPeakUsage() > 0);

    }

    /**
     * @since 1.0.0
     *
     * @return void
     */
    public function testResetMemoryPeakUsage ():void {

        SystemRuntime::resetMemoryPeakUsage();

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $seconds
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError
     *
     * @return void
     */
    #[TestWith([0])]
    public function testSleep (int $seconds):void {

        self::assertTrue(SystemRuntime::sleep($seconds));

    }

    /**
     * @since 1.0.0
     *
     * @param non-negative-int $seconds
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError
     *
     * @return void
     */
    #[TestWith([-1])]
    public function testSleepInvalidSeconds (int $seconds):void {

        $this->expectException(SleepTimeInvalidError::class);

        SystemRuntime::sleep($seconds);

    }

    /**
     * @since 1.0.0
     *
     * @param int<0, 999999> $microseconds
     *
     * @throws \FireHub\Core\Throwable\Error\LowLevel\SystemRuntime\SleepTimeInvalidError
     *
     * @return void
     */
    #[TestWith([1])]
    public function testMicrosleep (int $microseconds):void {

        SystemRuntime::microsleep($microseconds);

        self::assertTrue(true);

    }

    /**
     * @since 1.0.0
     *
     * @param int $value
     *
     * @return void
     */
    #[TestWith([-1])]
    #[TestWith([1_000_000])]
    public function testMicrosleepInvalidMicroseconds (int $value):void {

        $this->expectException(SleepTimeInvalidError::class);

        SystemRuntime::microsleep($value);

    }

}