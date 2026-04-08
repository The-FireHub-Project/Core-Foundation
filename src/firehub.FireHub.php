<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.4
 * @package Core
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core;

use FireHub\Core\Support\Bootstrap\FireHubConfigurator;
use FireHub\Core\Support\Bootstrap\Bootloader;
use FireHub\Core\Throwable\Exception\Support\Bootstrap\ {
    FailedToLoadBootloaderException, NotBootloaderException
};
use FireHub\Core\Support\LowLevel\ {
    DataIs, ClsObj
};

/**
 * ### Core Runtime Orchestrator
 *
 * The FireHub class represents the main runtime entry point of the FireHub Core framework.<br>
 * It is responsible for orchestrating the application lifecycle.
 * @since 1.0.0
 *
 * @internal
 */
final class FireHub {

    /**
     * ### Default bootloaders
     * @since 1.0.0
     *
     * @var array<int|class-string<\FireHub\Core\Support\Bootstrap\Bootloader>,
     *     class-string<\FireHub\Core\Support\Bootstrap\Bootloader>|array<array-key, mixed>>
     */
    private array $bootloaders = [
        \FireHub\Core\Support\Bootstrap\Bootloader\RegisterConstants::class,
        \FireHub\Core\Support\Bootstrap\Bootloader\RegisterHelpers::class,
        \FireHub\Core\Support\Bootstrap\Bootloader\RegisterAutoloaders::class
    ];

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\Bootstrap\FireHubConfigurator As a parameter.
     * @uses \FireHub\Core\FireHub::loadBootloaders() To load bootloaders.
     *
     * @param \FireHub\Core\Support\Bootstrap\FireHubConfigurator $configurator <p>
     * FireHub configurator.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Exception\Support\Bootstrap\FailedToLoadBootloaderException If a bootloader
     * fails to load.
     * @throws \FireHub\Core\Throwable\Exception\Support\Bootstrap\NotBootloaderException If a bootloader is not
     * a bootloader.
     *
     * @return void
     */
    public function __construct (
        private readonly FireHubConfigurator $configurator
    ) {

        $this->loadBootloaders();

    }

    /**
     * ### Light the torch
     *
     * This methode serves for instantiating the FireHub framework.
     * @since 1.0.0
     *
     * @return string Response string.
     */
    public function boot ():string {

        return 'FireHub Booted';

    }

    /**
     * ### Load bootloaders
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\DataIs::string() To check if the $key is a string.
     * @uses \FireHub\Core\Support\LowLevel\DataIs::array() To check if the $value is an array.
     * @uses \FireHub\Core\Support\LowLevel\ClsObj::ofClass() To check if the $value is a bootloader.
     * @uses \FireHub\Core\Support\Bootstrap\Bootloader::boot() To boot a bootloader.
     *
     * @throws \FireHub\Core\Shared\Contracts\Throwable
     * @throws \FireHub\Core\Throwable\Exception\Support\Bootstrap\FailedToLoadBootloaderException If a bootloader
     * fails to load.
     * @throws \FireHub\Core\Throwable\Exception\Support\Bootstrap\NotBootloaderException If a bootloader is not
     * a bootloader.
     *
     * @return void
     */
    private function loadBootloaders ():void {

        foreach ([...$this->bootloaders, ...$this->configurator->bootloaders] as $key => $value)
            match (true) {
                DataIs::string($key) && DataIs::array($value) && ClsObj::ofClass($key, Bootloader::class)
                    => new $key(...$value)->boot()
                        ?: throw FailedToLoadBootloaderException::builder()
                            ->withContext(['class' => $key])
                            ->build(),
                DataIs::string($value) && ClsObj::ofClass($value, Bootloader::class)
                    => new $value()->boot()
                        ?: throw FailedToLoadBootloaderException::builder()
                            ->withContext(['class' => $value])
                            ->build(),
                default => throw NotBootloaderException::builder()
                            ->withContext([
                                'key' => $key,
                                'value' => $value
                            ])
                            ->build()
            };

    }

}