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

namespace FireHub\Core\Support\Bootstrap;

use FireHub\Core\FireHub;

/**
 * ### Runtime Bootstrap Configuration Builder
 *
 * Defines and prepares the runtime configuration for the FireHub Core framework before execution begins.<br>
 * The configurator encapsulates all initialization decisions and separates configuration logic from execution logic.<br>
 * It ensures that the FireHub class remains a thin runtime coordinator and does not contain environment-specific or
 * adapter-specific setup logic.
 * @since 1.0.0
 */
final class FireHubConfigurator {

    /**
     * ### Bootloaders
     * @since 1.0.0
     *
     * @var array<int|class-string<\FireHub\Core\Support\Bootstrap\Bootloader>,
     *     class-string<\FireHub\Core\Support\Bootstrap\Bootloader>|array<array-key, mixed>>
     */
    private(set) array $bootloaders = [];

    /**
     * ### Initialize bootloaders
     *
     * Load the series of bootloaders required to boot FireHub framework.<br>
     * Bootloaders will be loaded before the kernel is loaded.
     * @since 1.0.0
     *
     * @param array<int|class-string<\FireHub\Core\Support\Bootstrap\Bootloader>, class-string<\FireHub\Core\Support\Bootstrap\Bootloader>|array<array-key, mixed>> $bootloaders <p>
     * List of bootloaders needed to load.
     * </p>
     *
     * @return $this This object.
     */
    public function withBootloaders (array $bootloaders):self {

        $this->bootloaders = $bootloaders;

        return $this;

    }

    /**
     * ### Create FireHub application
     * @since 1.0.0
     *
     * @uses \FireHub\Core\FireHub As return.
     *
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\FailedToLoadBootloaderException If a bootloader fails to
     * load.
     * @throws \FireHub\Core\Throwable\Exception\Bootstrap\NotBootloaderException If a bootloader is not a bootloader.
     *
     * @return \FireHub\Core\FireHub New Firehub Framework application.
     */
    public function create ():FireHub {

        return new FireHub($this);

    }

}