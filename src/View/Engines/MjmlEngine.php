<?php

namespace Edx\MJML\View\Engines;

use Illuminate\View\Engines\CompilerEngine;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class MjmlEngine extends CompilerEngine
{
    protected $mjmlCompiledPath;

    /**
     * Build the mjml command.
     *
     * @return string
     */
    public function buildCmdLineFromConfig()
    {
        return implode(' ', [$this->detectBinaryPath(), $this->mjmlCompiledPath, '-o', $this->mjmlCompiledPath]);
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @param string $path
     *
     * @return string
     */
    public function get($path, array $data = [])
    {
        $this->lastCompiled[] = $path;

        // If this given view has expired, which means it has simply been edited since
        // it was last compiled, we will re-compile the views so we can evaluate a
        // fresh copy of the view. We'll pass the compiler the path of the view.
        if ($this->compiler->isExpired($path)) {
            $this->compiler->compile($path);

            $this->compiledMjml($path);
        }

        // Once we have the path to the compiled file, we will evaluate the paths with
        // typical PHP just like any other templates. We also keep a stack of views
        // which have been rendered for right exception messages to be generated.
        $results = $this->evaluatePath($this->compiler->getCompiledPath($path), $data);

        array_pop($this->lastCompiled);

        return $results;
    }

    protected function compiledMjml($path)
    {
        $this->mjmlCompiledPath = $this->compiler->getCompiledPath($path);

        $process = Process::fromShellCommandline($this->buildCmdLineFromConfig());

        $process->run();

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Detect the path to the mjml executable.
     *
     * @return string
     */
    public function detectBinaryPath()
    {
        return config('mjml.auto_detect_path') ? config('mjml.path_to_binary') : base_path('node_modules/.bin/mjml');
    }
}
