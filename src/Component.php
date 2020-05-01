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
     * @note this is ignored if [[client]] is a Raven client instance.
     */
    public $dsn;

    /**
     * @var string environment name
     * @note this is ignored if [[client]] is a Raven client instance.
     */
    public $environment = 'production';

    public function init()
    {
        if (!$this->enabled) {
            return;
        }

        \Sentry\init([
            'dsn'           => $this->dsn,
            'environment'   => $this->environment
        ]);
    }

    public function captureMessage(string $message, ?Severity $level = null): ?string
    {
        return \Sentry\captureMessage($message, $level);
    }

    public function captureException(\Throwable $exception): ?string
    {
        return \Sentry\captureException($exception);
    }

    public function capture(array $payload): ?string
    {
        return \Sentry\captureEvent($payload);
    }

    public function configureScope(callable $callback): void
    {
        \Sentry\configureScope($callback);
    }

    public function withScope(callable $callback): void
    {
        \Sentry\withScope($callback);
    }
}
