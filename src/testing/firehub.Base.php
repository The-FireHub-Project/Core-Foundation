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

namespace FireHub\Core\Testing;

use PHPUnit\Framework\TestCase;

/**
 * ### FireHub Core Base Test Class
 *
 * Abstract base class for all FireHub Core tests, extending PHPUnit\Framework\TestCase. Provides a centralized
 * location for common setup, teardown, and custom assertions, ensuring consistency and maintainability across all Core
 * and Adapter test suites.
 * @since 1.0.0
 */
abstract class Base extends TestCase {}