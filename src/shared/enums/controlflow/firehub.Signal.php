<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/license/Apache-2-0 Apache License, Version 2.0
 *
 * @php-version 8.1
 * @package Core\Shared
 */

namespace FireHub\Core\Shared\Enums\ControlFlow;

/**
 * ### Control flow signals
 *
 * Generic control signals that can be used to influence the flow of iteration, pipelines, or other executable
 * sequences across the FireHub framework.
 * @since 1.0.0
 */
enum Signal {

    /**
     * ### Terminate Execution Flow
     *
     * Immediately stops the iteration or execution sequence and prevents any further processing of remaining items.
     * @since 1.0.0
     */
    case BREAK;

    /**
     * ### Continue Execution Flow
     *
     * Proceeds to the next iteration, marking the current item as processed and allowing normal execution flow to
     * continue without interruption.
     * @since 1.0.0
     */
    case CONTINUE;

    /**
     * ### Skip Current Processing Step
     *
     * Skips processing of the current iteration while keeping the iteration flow active, allowing the next item to
     * be evaluated without executing the current processing logic.
     * @since 1.0.0
     */
    case SKIP;

}