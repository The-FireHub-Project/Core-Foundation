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
 */

namespace FireHub\Core\Support\Contracts;

/**
 * ### Data structure Contract
 *
 * Represents the root abstraction for all data structures within the system.
 * A data structure defines the semantic interpretation and usage model of data, independent of its underlying storage
 * mechanism.<br>
 * It serves as a type identity and architectural boundary, enabling consistent classification, composition, and
 * interaction across different structural paradigms.<br>
 * This interface does not define behavior or operations but establishes a common contract for all structures that
 * organize and expose data meaningfully.
 * @since 1.0.0
 *
 * @template TKey
 * @template TValue
 */
interface DataStructure {}