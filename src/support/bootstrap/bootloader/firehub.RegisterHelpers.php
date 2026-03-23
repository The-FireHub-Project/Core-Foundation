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
use FireHub\Core\Support\LowLevel\FileSystem;
use DirectoryIterator, UnexpectedValueException;

/**
 * ### Global Helper Functions Loader
 *
 * Registers core helper functions that can be used throughout the FireHub framework.
 * @since 1.0.0
 *
 * @internal
 */
final class RegisterHelpers implements Bootloader {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\FileSystem::parent() To get a parent for the current folder.
     */
    public function boot ():bool {

        try {

            foreach (new DirectoryIterator(FileSystem::parent(__DIR__, 3) . '/shared/helpers') as $file)
                if ($file->isFile() && $file->getExtension() === 'php') include $file->getPathname();

        } catch (UnexpectedValueException) {

            return false;

        }

        return true;

    }

}