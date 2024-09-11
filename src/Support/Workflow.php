<?php

namespace CraigPaul\Blitz\Support;

use function array_reverse;
use function base_path;
use function explode;
use function implode;
use function preg_split;
use SplFileInfo;
use function str_replace;
use function strstr;
use function strtolower;
use function ucfirst;

class Workflow
{
    /**
     * Create a new Workflow instance.
     *
     * @param string $className
     * @param bool $customizable
     * @param string $name
     * @param string $path
     *
     * @return void
     */
    public function __construct(
        public readonly string $className,
        public readonly bool $customizable,
        public readonly string $name,
        public readonly string $path,
    ) {
    }

    /**
     * Create a new Workflow instance from the given file.
     *
     * @param \SplFileInfo $file
     *
     * @return static
     */
    public static function fromFile(SplFileInfo $file): static
    {
        $path = $file->getPathname();

        $instance = new static(
            // TODO: The way this className property is generated precludes it from being more then a single directory deep. It will only work with files inside of `tests/Blitz`.
            className: str_replace(
                ['/', '.php'],
                ['\\', ''],
                ucfirst(
                    ltrim(
                        array_reverse(
                            explode(rtrim(base_path('/'), '/'), $path, 2)
                        )[0],
                        '/',
                    ),
                ),
            ),
            customizable: self::fileContains($file, 'public function fields()'),
            name: ucfirst(
                strtolower(
                    implode(' ', preg_split('/(?=\p{Lu})/u', strstr($file->getFilename(), 'Test.php', true), -1, PREG_SPLIT_NO_EMPTY)),
                ),
            ),
            path: $path,
        );

        return $instance;
    }

    /**
     * Determine if the given file contains the given needle.
     *
     * @param \SplFileInfo $file
     * @param string $needle
     *
     * @return bool
     */
    protected static function fileContains(SplFileInfo $file, string $needle): bool
    {
        if ($file->isReadable() === false) {
            return false;
        }

        $handle = fopen($file->getRealPath(), 'r');

        if ($handle === false) {
            return false;
        }

        while (($line = fgets($handle)) !== false) {
            if (strpos($line, $needle) !== false) {
                fclose($handle);

                return true;
            }
        }

        fclose($handle);

        return false;
    }
}
