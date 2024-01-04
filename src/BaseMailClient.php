<?php

namespace LaravelMail;

use LaravelMail\Interface\MailClientInterface;

use LaravelMail\Trait\Mailable;

use LaravelMail\Trait\Envelope;
use LaravelMail\Trait\Content;
use LaravelMail\Trait\Attachments;
use LaravelMail\Trait\Headers;

/**
 * Laravelのメール送信機能を拡張した基底クラス
 * 
 * @package LaravelMail
 */
abstract class BaseMailClient implements MailClientInterface
{
    use Mailable;

    use Envelope;
    use Content;
    use Attachments;
    use Headers;
}
