<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @package Core\Test
 *
 * @version GIT: $Id$ Blob checksum.
 */

namespace FireHub\Tests\Unit\Support\LowLevel;

use FireHub\Core\Testing\Base;
use FireHub\Core\Support\LowLevel\StrMB;
use PHPUnit\Framework\Attributes\ {
    CoversClass, Group, Small
};

/**
 * ### Test Multibyte string low-level proxy class
 * @since 1.0.0
 */
#[Small]
#[Group('lowlevel')]
#[CoversClass(StrMB::class)]
final class StrMBTest extends Base {



}