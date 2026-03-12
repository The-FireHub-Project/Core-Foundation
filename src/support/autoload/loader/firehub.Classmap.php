<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 7.0
 * @package Core\Support
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Support\Autoload\Loader;

use FireHub\Core\Support\Autoload\Loader;

/**
 * ### Classmap Autoload Loader
 *
 * Provides a high-performance class loading mechanism based on a precompiled class-to-file map.<br>
 * Instead of resolving namespaces dynamically, this loader performs a direct lookup of fully qualified class names
 * in an internal classmap and requires the corresponding file when found.<br>
 * This approach minimizes filesystem lookups and string operations during autoloading, making it particularly
 * suitable for optimized production environments and PHAR distributions where class locations are known in advance.
 * @since 1.0.0
 *
 * @internal
 */
final readonly class Classmap implements Loader {

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param array<class-string, non-empty-string> $map <p>
     * Class-to-file map.
     * </p>
     *
     * @return void
     */
    public function __construct (
        private array $map
    ) {}

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function __invoke (string $class):void {

        if (!isset($this->map[$class])) return;

        require $this->map[$class];

    }

}