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

namespace FireHub\Core\Support\DataStructure\Storage\Capability;

/**
 * ### Back Mutation Capability
 *
 * Combines back insertion and back removal, enabling full mutation of the logical end of the structure.
 * @since 1.0.0
 *
 * @template TValue
 *
 * @extends \FireHub\Core\Support\DataStructure\Storage\Capability\BackInsertion<TValue>
 */
interface BackMutation extends BackInsertion, BackRemoval {}