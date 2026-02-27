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
use FireHub\Core\Throwable\Exception\Domain\Autoload\ {
    InvalidFolderException, InvalidNamespaceException
};
use FireHub\Core\Support\LowLevel\ {
    Arr, FileSystem, StrSB
};

use const FireHub\Core\Shared\Constants\Path\DS;

/**
 * ### Resolver Autoload Loader
 *
 * Responsible for resolving fully qualified class names into concrete file system paths based on registered
 * namespace prefixes and directory mappings.<br>
 * Provides a PSR-4–inspired resolution strategy and serves as the core resolution engine for the FireHub autoloading
 * layer.
 * @since 1.0.0
 */
final class Resolver implements Loader {

    /**
     * ### List of namespaces prefixes with its folders
     *
     * An associative array where the key is a namespace prefix, and the value is an array of base folders for classes
     * in that namespace.
     * @since 1.0.0
     *
     * @var array<non-empty-string, non-empty-string[]>
     */
    private array $namespaces = [];

    /**
     * ### Constructor
     * @since 1.0.0
     *
     * @param string $class_prefix [optional] <p>
     * Filename prefix.
     * </p>
     *
     * @return void
     */
    public function __construct (
        private readonly string $class_prefix = ''
    ) {}

    /**
     * ### Adds a base folder for a namespace prefix
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::trim() To trim characters from folders and namespaces.
     * @uses \FireHub\Core\Support\LowLevel\Arr::inArray() To check if the folder is already registered.
     *
     * @param non-empty-string $namespace_prefix <p>
     * Namespaces prefix.
     * </p>
     * @param non-empty-string $folder <p>
     * Base folder.
     * </p>
     *
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidFolderException If folder us empty.
     * @throws \FireHub\Core\Throwable\Exception\Domain\Autoload\InvalidNamespaceException If namespace us empty.
     *
     * @return void
     */
    public function addNamespace (string $namespace_prefix, string $folder):void {

        $namespace_prefix = StrSB::trim(
            StrSB::trim($namespace_prefix),
            characters: '\\/'
        ) ?: throw InvalidNamespaceException::empty();

        $folder = StrSB::trim(
            StrSB::trim($folder),
            characters: '\\/'
        ) ?: throw InvalidFolderException::empty();

        $this->namespaces[$namespace_prefix] ??= [];
        if (!Arr::inArray($this->namespaces[$namespace_prefix], $folder))
            $this->namespaces[$namespace_prefix][] = $folder;

    }

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::startsWith() To check if the class is in the namespace.
     * @uses \FireHub\Core\Support\Autoload\Loader\Resolver::getPath() To get a class path.
     * @uses \FireHub\Core\Support\LowLevel\FileSystem::isFile() To check if a path is a valid file.
     */
    public function __invoke (string $class):void {

        foreach ($this->namespaces as $namespace_prefix => $folders) {

            if (StrSB::startsWith($namespace_prefix.'\\', $class)) {

                $path = $this->getPath($class, $namespace_prefix);

                foreach ($folders as $folder)
                    if ($this->requireFile($folder.$path))
                        break;

            }

        }

    }

    /**
     * ### Get class path
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\StrSB::part() To get a part of a string.
     * @uses \FireHub\Core\Support\LowLevel\StrSB::length() To get the length of a string.
     * @uses \FireHub\Core\Support\LowLevel\StrSB::trim() To trim characters from folders and namespaces.
     * @uses \FireHub\Core\Support\LowLevel\StrSB::toLower() To convert a string to lowercase.
     * @uses \FireHub\Core\Support\LowLevel\StrSB::lastCharacterFrom() To get the last character from a string.
     * @uses \FireHub\Core\Support\LowLevel\StrSB::replace() To replace characters in a string.
     * @uses \FireHub\Core\Shared\Constants\Path\DS To separate folders.
     *
     * @param string $class <p>
     * Fully qualified class name that is being loaded.
     * </p>
     * @param non-empty-string $namespace_prefix <p>
     * Namespaces prefix.
     * </p>
     *
     * @return non-empty-string Class path.
     */
    private function getPath (string $class, string $namespace_prefix):string {

        $class = StrSB::part($class, StrSB::length($namespace_prefix));

        $namespace = StrSB::toLower(StrSB::lastCharacterFrom('\\', $class, true) ?: '').'\\';

        $classname = StrSB::trim(StrSB::lastCharacterFrom('\\', $class) ?: '', characters: '\\');

        return StrSB::replace('\\', DS, $namespace.$this->class_prefix.$classname).'.php';

    }

    /**
     * ### Include a file
     * @since 1.0.0
     *
     * @uses \FireHub\Core\Support\LowLevel\FileSystem::isFile() To check if a path is a valid file.
     *
     * @param non-empty-string $path <p>
     * Path to a required file.
     * </p>
     *
     * @return bool True if a file is included, false otherwise.
     */
    private function requireFile (string $path):bool {

        if (!FileSystem::isFile($path))
            return false;

        require $path;

        return true;

    }

}