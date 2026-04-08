<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * This is a landing file if the PHAR archive.
 * @since 1.0.0
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @php-version 7.0
 * @package Core\Public
 */

namespace FireHub\Core\Public;

require __DIR__.'/../support/firehub.LowLevel.php';
require __DIR__.'/../support/firehub.Autoload.php';
require __DIR__.'/../support/lowlevel/firehub.SplAutoload.php';
require __DIR__.'/../support/autoload/firehub.Loader.php';
require __DIR__.'/../support/autoload/loader/firehub.Classmap.php';
require __DIR__.'/../support/autoload/loader/firehub.CompiledClassmap.php';
require __DIR__.'/../shared/contracts/magic/firehub.Stringable.php';
require __DIR__.'/../shared/contracts/firehub.Throwable.php';
require __DIR__.'/../shared/firehub.ValueObject.php';
require __DIR__.'/../domain/autoload/firehub.Handle.php';
require __DIR__.'/../throwable/firehub.Builder.php';
require __DIR__.'/../throwable/firehub.ErrorBuilder.php';
require __DIR__.'/../throwable/firehub.ExceptionBuilder.php';
require __DIR__.'/../throwable/firehub.Throwable.php';
require __DIR__.'/../throwable/firehub.Error.php';
require __DIR__.'/../throwable/firehub.Exception.php';
require __DIR__.'/../throwable/exception/domain/autoload/firehub.InvalidHandleException.php';

use FireHub\Core\Support\Autoload;
use FireHub\Core\Support\Autoload\Loader\Classmap;
use FireHub\Core\Support\Autoload\Loader\CompiledClassmap;
use FireHub\Core\Domain\Autoload\Handle;

/** @var array<class-string, non-empty-string> $classmap */
$classmap = require __DIR__.'/../support/autoload/classmap.php';

Autoload::prepend(
    new Handle('FireHub_Classmap'),
    new Classmap($classmap)
);

Autoload::prepend(
    new Handle('FireHub_CompiledClassmap'),
    new CompiledClassmap()
);