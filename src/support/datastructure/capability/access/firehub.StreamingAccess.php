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

namespace FireHub\Core\Support\DataStructure\Capability\Access;

/**
 * ### Streaming Access
 *
 * Defines the ability to access elements in a single-pass, forward-only manner where each element is produced or
 * consumed once. It does not support revisiting or random retrieval of previously seen elements.
 * @since 1.0.0
 */
interface StreamingAccess {}