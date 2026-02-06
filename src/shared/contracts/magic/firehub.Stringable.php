<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.0
 * @package Core\Shared
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Core\Shared\Contracts\Magic;

use Stringable as InternalStringable;

/**
 * ### Stringable contract
 *
 * The Stringable interface defines a contract for objects that can be safely and deterministically represented as a
 * string. It is intended for value-like objects, diagnostics, identifiers, error representations, and framework
 * primitives that must expose a canonical string form without side effects.
 * @since 1.0.0
 */
interface Stringable extends InternalStringable {

    /**
     * ### Gets a string representation of the object
     * @since 1.0.0
     *
     * @return string The string representation of the object.
     */
    public function __toString ():string;

}