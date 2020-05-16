<?php

namespace dmftaras\sentry;

use Sentry\Integration\RequestIntegration;
use Sentry\Integration\TransactionIntegration;
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

    /**
     * @var array pre execution callbacks
     */
    public $callbacks;

    public function init()
    {
        if ($this->enabled) {
            \Sentry\init([
                'dsn' => $this->dsn,
                'environment' => $this->environment,
                'release'   => $this->release,
                'default_integrations' => false,
                'integrations' => [
                    new RequestIntegration(),
                    new TransactionIntegration(),
                ]
            ]);
        }

        return $this;
    }

    /**
     * Capture message
     * @param string $message
     * @param Severity|null $level
     * @return string|null
     */
    public function captureMessage(string $message, ?Severity $level = null)
    {
        if ($this->enabled) {
            $this->_trigger(__FUNCTION__);
            return \Sentry\captureMessage($message, $level);
        }
    }

    /**
     * Capture exception
     * @param \Throwable $exception
     * @return string|null
     */
    public function captureException(\Throwable $exception)
    {
        if ($this->enabled) {
            $this->_trigger(__FUNCTION__);
            return \Sentry\captureException($exception);
        }
    }

    /**
     * Capture data
     * @param array $payload
     * @return string|null
     */
    public function capture(array $payload)
    {
        if ($this->enabled) {
            $this->_trigger(__FUNCTION__);
            return \Sentry\captureEvent($payload);
        }
    }

    public function configureScope(callable $callback)
    {
        if ($this->enabled)
            \Sentry\configureScope($callback);
    }

    public function withScope(callable $callback)
    {
        if ($this->enabled)
            \Sentry\withScope($callback);
    }

    private function _trigger($method)
    {
        if (is_array($this->callbacks)) {
            $keys = ['any', $method];
            foreach ($keys as $key) {
                if (isset($this->callbacks[$key]) && is_callable($this->callbacks[$key])) $this->callbacks[$key]($this);
            }
        }
    }
}
