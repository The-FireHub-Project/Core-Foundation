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

namespace FireHub\Tests\DataProviders;

use Countable;

/**
 * ### Class data provider
 * @since 1.0.0
 */
final class ClassDataProvider {

    /**
     * @since 1.0.0
     *
     * @return array<object<Countable>>
     */
    public static function countable ():array {

        return [
            [new class implements Countable {

                public function count():int {return 10;}

            }]
        ];

    }

}