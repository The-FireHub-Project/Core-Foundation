<?php declare(strict_types = 1);

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

/**
 * ### Build PHAR archive
 */
readonly class Build {

    /**
     * ### Phar
     * @var Phar
     */
    private Phar $phar;

    /**
     * ### Constructor
     *
     * @param string $name <p>
     * Package name.
     * </p>
     * @param string $version <p>
     * Package name.
     * </p>
     * @param string $phar_name <p>
     * Phar name.
     * </p>
     * @param string $source <p>
     * Relative source for phar files.
     * </p>
     * @param string $vendor_source <p>
     * Relative source for vendor phar files.
     * </p>
     * @param string $index <p>
     * Relative path within the phar archive to run if accessed.
     * </p>
     * @param bool $minified <p>
     * If set, it will create a minified version of phar archive.
     * </p>
     *
     * @return void
     */
    public function __construct (
        private string $name,
        private string $version,
        private string $phar_name,
        private string $source,
        private string $vendor_source,
        private string $index,
        private bool $minified = false
    ) {

        $this->cleanup($this->phar_name);

        $this->phar = new Phar($this->phar_name);
        $this->phar();
        $this->sign();
        $this->copy($this->phar_name);

    }

    /**
     * ### Clean old phar files
     *
     * @param string $phar_name <p>
     * Phar name.
     * </p>
     *
     * @return void
     */
    private function cleanup (string $phar_name):void {

        if (file_exists($phar_name)) unlink($phar_name);

    }

    /**
     * ### Create phar archive
     *
     * @return void
     */
    private function phar ():void {

        $this->phar->startBuffering();
        foreach (
            new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($this->source),
                RecursiveIteratorIterator::SELF_FIRST
            ) as $file
        ) {
            if ($file->isFile())
                $this->phar->addFromString(
                    substr($file->getPathname(), strlen($this->source) + 1),
                    $this->minified ? php_strip_whitespace($file->getPathname()) : file_get_contents($file->getPathname())
                );
        }

        $this->stub();

        $this->metadata();

    }

    /**
     * ### Stub phar archive
     *
     * @return void
     */
    private function stub ():void {

        $index = $this->index;

        $stub = <<<PHAR
        <?php
        require 'phar://' . __FILE__ . '/$index';
        __HALT_COMPILER();
        ?>
        PHAR;

        $this->phar->setStub($stub);

    }

    /**
     * ### Set metadata to phar archive
     *
     * @return void
     */
    private function metadata ():void {

        $this->phar->setMetadata([
            'name' => $this->name,
            'version' => $this->version
        ]);

    }

    /**
     * ### Sign phar archive
     *
     * @return void
     */
    private function sign ():void {

        $private_key = file_get_contents(__DIR__.'\private.pem');
        $this->phar->setSignatureAlgorithm(Phar::OPENSSL_SHA512, $private_key);
        $this->phar->stopBuffering();

    }

    /**
     * ### Copy phar and public key to the vendor folder
     *
     * @param string $phar_name <p>
     * Phar name.
     * </p>
     *
     * @return void
     */
    private function copy (string $phar_name):void {

        copy(
            $phar_name,
            $this->vendor_source.$phar_name
        ) && copy(
            $phar_name.'.pubkey',
            $this->vendor_source.$phar_name.'.pubkey'
        );

    }

    /**
     * ### String representation of an object
     *
     * @return string
     */
    public function __toString ():string {

        return $this->phar_name." was successfully built.\r\n";

    }

    /**
     * ### Generate compiled classmap file
     *
     * @param array<int, string> $folders <p>
     * List of folders to scan for classes,
     * </p>
     * @param non-empty-string $output <p>
     * Output file path.
     * </p>
     *
     * @return void
     */
    public function generateCompiledClassmap (array $folders, string $output):void {

        $classmap = $this->generateClassmapData($folders);

        $cases = [];

        foreach ($classmap as $class => $path) {

            $cases[] = "            case \\$class::class:\n                require __DIR__.'/../../../$path';\n                return;";

        }

        $casesCode = implode("\n\n", $cases);

        $idTag = '$Id$';

        if (is_file($output)) {

            $existing = file_get_contents($output);

            if (preg_match('/\$Id$]+\$/', $existing, $m)) $idTag = $m[0];

        }

        $content = <<<PHP
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
 * @version GIT: $idTag Blob checksum.
 */

namespace FireHub\Core\Support\Autoload\Loader;

use FireHub\Core\Support\Autoload\Loader;

/**
 * ### High-performance compiled classmap autoloader
 *
 * CompiledClassmap is a final autoloader implementation that replaces traditional array-based or PSR-4 class
 * resolution with a switch-based dispatch.<br>
 * Each fully qualified class name maps directly to a required statement, eliminating runtime array lookups and
 * filesystem checks. This approach is optimized for PHAR distribution and production environments, providing
 * significantly faster class loading—up to 2–5× faster than standard classmaps, and up to 10× faster when combined
 * with a single-file compiled core. It is intended to be used after a minimal Preloader and before a Resolver fallback,
 * ensuring all core classes are loaded efficiently while maintaining full namespace support.
 * @since 1.0.0
 *
 * @internal
 */
final readonly class CompiledClassmap implements Loader {

    /**
     * @inheritDoc
     *
     * @since 1.0.0
     */
    public function __invoke (string \$class):void {

        switch (\$class) {

$casesCode

        }

    }

}
PHP;

        file_put_contents($output, $content);

    }

    /**
     * ### Generate classmap file
     *
     * @param array<int, string> $folders <p>
     * List of folders to scan for classes,
     * </p>
     * @param non-empty-string $output <p>
     * Output file path.
     * </p>
     *
     * @return void
     */
    public function generateClassmap (array $folders, string $output):void {

        $classmap = $this->generateClassmapData($folders);

        $lines = [];

        foreach ($classmap as $class => $path) {

            $class = '\\' . ltrim($class, '\\');

            $lines[] = "    $class::class => __DIR__.'/../../$path',";

        }

        $export = "[\n" . implode("\n", $lines) . "\n]";

        $idTag = '$Id$';

        if (is_file($output)) {

            $existing = file_get_contents($output);

            if (preg_match('/\$Id$]+\$/', $existing, $m)) $idTag = $m[0];

        }

        $content = <<<PHP
<?php declare(strict_types = 1);

/**
 * This file is part of the FireHub Project ecosystem
 *
 * Pre-generated mapping of fully qualified class names to their file paths.
 * @since 1.0.0
 *
 * @author Danijel Galić <danijel.galic@outlook.com>
 * @copyright 2026 The FireHub Project - All rights reserved
 * @license https://opensource.org/licenses/MIT MIT License
 *
 * @php-version 7.0
 * @package Core\Support
 *
 * @version GIT: $idTag Blob checksum.
 */

namespace FireHub\Core\Support\Autoload;

/**
 * ### Pre-generated mapping of fully qualified class names to their file paths
 *
 * This file is used by the FireHub autoloader to resolve classes without performing filesystem scanning,
 * significantly reducing bootstrap time.<br>
 * The classmap is generated during the build process and should not be modified manually.
 * @since 1.0.0
 *
 * @return array<class-string, non-empty-string>
 */
return $export;
PHP;

        file_put_contents($output, $content);

    }

    /**
     * ### Generate classmap data
     *
     * @param array<int, string> $folders <p>
     * List of folders to scan for classes,
     * </p>
     *
     * @return array<string, string>
     */
    private function generateClassmapData (array $folders):array {

        $classmap = [];

        foreach ($folders as $folder) {
            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($folder)
            );

            foreach ($iterator as $file) {

                if (!$file->isFile() || $file->getExtension() !== 'php') continue;

                foreach ($this->extractClassesToken($file->getPathname()) as $class) {

                    $relativePath = substr($file->getPathname(), strlen($folder) + 1);
                    $relativePath = str_replace('\\', '/', $relativePath);
                    $classmap[$class] = $relativePath;

                }

            }

        }

        ksort($classmap);

        return $classmap;

    }

    /**
     * ### Extract fully qualified class names using PHP tokenizer
     *
     * @return array<int, string>
     */
    private function extractClassesToken (string $file):array {

        $content = file_get_contents($file);

        if (
            !str_contains($content, 'class') &&
            !str_contains($content, 'interface') &&
            !str_contains($content, 'trait') &&
            !str_contains($content, 'enum')
        ) return [];

        $tokens = token_get_all($content);

        $classes = [];
        $namespace = '';
        $count = count($tokens);

        foreach ($tokens as $i => $i_value) {

            $token = $i_value;

            if (!is_array($token)) continue;

            switch ($token[0]) {

                case T_NAMESPACE:

                    $namespace = '';

                    for ($j = $i + 1; $j < $count; $j++) {

                        if (!is_array($tokens[$j])) break;

                        if ($tokens[$j][0] === T_WHITESPACE) continue;

                        if (in_array(
                            $tokens[$j][0],
                            [
                                T_STRING,
                                T_NS_SEPARATOR,
                                defined('T_NAME_QUALIFIED') ? T_NAME_QUALIFIED : -1,
                                defined('T_NAME_FULLY_QUALIFIED') ? T_NAME_FULLY_QUALIFIED : -1,
                            ],
                            true
                        )) {

                            $namespace .= $tokens[$j][1];

                            continue;

                        }

                        break;

                    }

                    break;

                case T_CLASS:

                case T_INTERFACE:

                case T_TRAIT:

                case defined('T_ENUM') ? T_ENUM : -1:

                    if (($tokens[$i - 1][0] ?? null) === T_DOUBLE_COLON) break;

                    if (($tokens[$i - 1][0] ?? null) === T_NEW) break;

                    for ($j = $i + 1; $j < $count; $j++) {

                        if (!is_array($tokens[$j])) break;

                        if ($tokens[$j][0] === T_WHITESPACE) continue;

                        if ($tokens[$j][0] === T_STRING) {

                            $class = $tokens[$j][1];

                            $classes[] = $namespace
                                ? $namespace . '\\' . $class
                                : $class;

                            break;

                        }

                        break;

                    }

                    break;

            }

        }

        return $classes;

    }

}

$build = new Build(
    'core-foundation',
    'v0.3.0',
    'core.phar',
    __DIR__ . '/../src',
    '..\..\skeleton\vendor\firehub\core-foundation\phar\\',
    '/public/index.php',
    false
);
$build->generateClassmap(
    [
        __DIR__.'/../src'
    ],
    __DIR__.'/../src/support/autoload/classmap.php'
);
$build->generateCompiledClassmap(
    [
        __DIR__.'/../src'
    ],
    __DIR__.'/../src/support/autoload/loader/firehub.CompiledClassmap.php'
);

echo $build;

$build = new Build(
    'core-foundation',
    'v0.3.0',
    'core.min.phar',
    __DIR__ . '/../src',
    '..\..\skeleton\vendor\firehub\core-foundation\phar\\',
    '/public/index.php',
    true
);

echo $build;