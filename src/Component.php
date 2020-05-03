<?php

namespace dmftaras\sentry;

use Sentry\Severity;

class Component extends \yii\base\Component
{

    /**
     * Set to `false` in development environment to skip collecting errors
     *
     * @var bool
     */
    public $enabled = true;

    /**
     * @var string Sentry DSN
     */
    public $dsn;

    /**
     * @var string app release
     */
    public $release;

    /**
     * @var string environment name
     */
    public $environment = 'production';

    public function init()
    {
        if ($this->enabled) {
            \Sentry\init([
                'dsn' => $this->dsn,
                'environment' => $this->environment,
                'release'   => $this->release
            ]);
        }

        return $this;
    }

    public function captureMessage(string $message, ?Severity $level = null): ?string
    {
        if ($this->enabled)
            return \Sentry\captureMessage($message, $level);
    }

    public function captureException(\Throwable $exception): ?string
    {
        if ($this->enabled)
            return \Sentry\captureException($exception);
    }

    public function capture(array $payload): ?string
    {
        if ($this->enabled)
            return \Sentry\captureEvent($payload);
    }

    public function configureScope(callable $callback): void
    {
        if ($this->enabled)
            \Sentry\configureScope($callback);
    }

    public function withScope(callable $callback): void
    {
        if ($this->enabled)
            \Sentry\withScope($callback);
    }
}
