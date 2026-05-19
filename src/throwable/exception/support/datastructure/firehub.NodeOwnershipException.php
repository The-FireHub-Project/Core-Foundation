<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.3
 * @package Core\Throwable
 */

namespace FireHub\Core\Throwable\Exception\Support\DataStructure;

use FireHub\Core\Throwable\Exception;

/**
 * ### Provided node has the wrong ownership
 * @since 1.0.0
 */
class NodeOwnershipException extends Exception {

    /**
     * @inheritdoc
     *
     * @since 1.0.0
     */
    protected const string DEFAULT_MESSAGE = 'Provided node has the wrong ownership.';

}