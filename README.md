Yii 2 - Sentry Error Logger
==================

[Sentry](https://getsentry.com/) provides real-time crash reporting for web apps, both server and client side. This is a Yii 2 extension which lets you integrate your projects to Sentry and log PHP and JavaScript errors.

Brought to you by [dmftaras](http://dmftaras.com). 

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist dmftaras/yii2-sentry "~1.0.0"
```

or add the following line to the require section of your `composer.json` file:

```
"dmftaras/yii2-sentry": "~1.0.0"
```

## Requirements

Yii 2 and above.
Sentry 9 and above.

You can use this extension with both the hosted and on-premise version of Sentry. 


## Usage

Once the extension is installed, set your configuration in common config file:

```php
    'components' => [
        'sentry' => [
            'class' => 'dmftaras\sentry\Component',
            'dsn' => 'YOUR-PRIVATE-DSN', // private DSN
            'environment' => 'staging', // if not set, the default is `production`
            'release' => '1.0' // release version
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'dmftaras\sentry\Target',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ],
            ],
        ],
    ],
```

To skip collecting errors in the development environment, disable the component with this parameter:

```php
    'components' => [
        'sentry' => [
            'enabled' => false,
        ],
    ],
```

To collect error manually

```php
try {
    throw new \Exception('fatal error');
} catch (\Exception $e) {
    \Yii::$app->sentry->captureException($e);
}
```

To collect custom message
```php
\Yii::$app->sentry->captureMessage('test msg');
```

## License

Code released under [MIT License](LICENSE).
