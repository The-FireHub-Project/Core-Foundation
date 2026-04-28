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
 * ### Fluent Error Builder
 *
 * Provides a fluent, controlled construction mechanism for framework-level and low-level Error instances.<br>
 * This builder is responsible for assembling immutable Error objects by collecting message, code, context, and
 * previous throwable information before instantiating the final Error.
 * @since 1.0.0
 *
 * @template TThrowable of \FireHub\Core\Throwable\Error
 *
 * @extends \FireHub\Core\Throwable\Builder<TThrowable>
 *
 * @internal
 */
final class ErrorBuilder extends Builder {}