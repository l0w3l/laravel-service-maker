<?php

declare(strict_types=1);

namespace Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\Stub;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Lowel\LaravelServiceMaker\Commands\Abstract\Commands\Files\FileBuffer;

class StubBuilder
{
    /**
     * @var string string buffer of file stub
     */
    protected string $file;

    /** @var array<callable(string): string> */
    protected array $steps = [];

    protected Filesystem $filesystem;

    /**
     * @throws FileNotFoundException
     */
    public function __construct(
        Filesystem $filesystem,
        FileMetadataInterface $stub
    ) {
        $this->filesystem = $filesystem;
        $this->file = $this->filesystem->get($stub->getStubPath());
    }

    public function set(StubKeywordEnum $keywordEnum, string $value): self
    {
        return $this->setStep(
            fn (string $buffer) => $this->regReplace($keywordEnum, $value, $buffer)
        );
    }

    public function make(): FileBuffer
    {
        $buffer = $this->file;

        foreach (array_reverse($this->steps) as $step) {
            $buffer = $step($buffer);
        }

        return new FileBuffer($this->filesystem, $buffer);
    }

    private function regReplace(StubKeywordEnum $keywordEnum, string $replaced, string $buffer): string
    {
        return preg_replace($keywordEnum->getReg(), $replaced, $buffer, 1);
    }

    private function setStep(callable $callable): self
    {
        $this->steps[] = $callable;

        return $this;
    }
}
