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
     * @param string $name
     * @param string $path
     *
     * @return void
     */
    public function __construct(
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
        return new static(
            name: ucfirst(
                strtolower(
                    implode(' ', preg_split('/(?=\p{Lu})/u', strstr($file->getFilename(), 'Test.php', true), -1, PREG_SPLIT_NO_EMPTY)),
                ),
            ),
            path: $file->getPathname(),
        );
    }

    /**
     * Convert the current path into the appropriate PSR-4 compatible namespace.
     *
     * @return string
     */
    public function className(): string
    {
        return str_replace(
            ['/', '.php'],
            ['\\', ''],
            ucfirst(
                array_reverse(
                    explode(base_path('/'), $this->path, 2)
                )[0],
            ),
        );
    }
}
