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

namespace FireHub\Core\Throwable;

/**
 * ### Fluent Exception Builder
 *
 * Provides a fluent and expressive way to construct domain, application, infrastructure, or kernel-level Exception
 * instances.<br>
 * This builder collects structured data such as message, code, context metadata, and previous throwable references
 * before instantiating the final immutable Exception object.
 * @since 1.0.0
 *
 * @template TThrowable of \FireHub\Core\Throwable\Exception
 *
 * @extends \FireHub\Core\Throwable\Builder<TThrowable>
 *
 * @internal
 */
final class ExceptionBuilder extends Builder {}