<?php

namespace LaravelMail\Trait;

use LaravelMail\LaravelMail;

use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\PendingMail;

/**
 * Artisanコマンドで生成したMailableクラスを管理する
 * 
 * @package LaravelMail\Trait
 * 
 * @method \Illuminate\Mail\Mailables\Envelope getEnvelope()
 * @method \Illuminate\Mail\Mailables\Content getContent()
 * @method array<int, \Illuminate\Mail\Mailables\Attachment> getAttachments()
 * @method \Illuminate\Mail\Mailables\Headers getHeaders()
 */
trait Mailable
{
    /**
     * 使用するMailerのドライバー名
     * 
     * @var ?string
     */
    protected ?string $driver = null;

    /**
     * メールに使用する言語
     * 
     * @var ?string
     */
    protected ?string $locale = null;

    /**
     * メールをQueueに登録する際のConnection名
     * 
     * @var ?string
     */
    protected ?string $queueConnection = null;

    /**
     * メールをQueueに登録する際のQueue名
     * 
     * @var ?string
     */
    protected ?string $queueName = null;

    /**
     * メールをQueueに登録する処理をTransactionのCommit後に実行するかどうか
     * 
     * @var bool
     */
    protected bool $queueAfterCommit = false;


    /**
     * メールを送信する
     * 
     * @return void
     */
    public function send(): void
    {
        // Mailクラスを生成する
        $mail = $this->getMailInstance();

        // PendingMailクラスを生成する
        $pendingMail = $this->getPendingMail();

        // メールを送信する
        $pendingMail->send($mail);
    }

    /**
     * メールに使用される評価済みのHTMLを取得する
     * 
     * @return string
     */
    public function render(): string
    {
        // Mailクラスを生成する
        $mail = $this->getMailInstance();

        return $mail->render();
    }



    /*----------------------------------------*
     * Mail
     *----------------------------------------*/

    /**
     * Mailクラスを生成する
     * 
     * @return \LaravelMail\LaravelMail
     */
    protected function getMailInstance(): LaravelMail
    {
        return new LaravelMail(
            $this->getEnvelope(),
            $this->getContent(),
            $this->getAttachments(),
            $this->getHeaders(),
        );
    }



    /*----------------------------------------*
     * Mailer
     *----------------------------------------*/

    /**
     * Mailerインスタンスを生成する
     * 
     * @return \Illuminate\Contracts\Mail\Mailer
     */
    protected function getMailer(): Mailer
    {
        return MailFacade::mailer($this->driver());
    }

    /**
     * 使用するMailerのドライバー名を取得する
     * 
     * @return ?string
     */
    public function driver(): ?string
    {
        return $this->driver;
    }

    /**
     * 使用するMailerのドライバー名を設定する
     * 
     * @param string $driver
     * @return static
     */
    public function setDriver(string $driver): static
    {
        $this->driver = $driver;

        return $this;
    }



    /*----------------------------------------*
     * Pending Mail
     *----------------------------------------*/

    /**
     * PendingMailインスタンスを生成する
     * 
     * @return \Illuminate\Mail\PendingMail
     */
    protected function getPendingMail(): PendingMail
    {
        $pendingMail = new PendingMail($this->getMailer());

        // locale
        $locale = $this->locale();

        if (is_string($locale)) $pendingMail = $pendingMail->locale($locale);

        return $pendingMail;
    }

    /**
     * メールに使用する言語を取得する
     * 
     * @return ?string
     */
    public function locale(): ?string
    {
        return $this->locale;
    }

    /**
     * メールに使用する言語を設定する
     * 
     * @param string $locale
     * @return static
     */
    public function setLocale(string $locale): static
    {
        $this->locale = $locale;

        return $this;
    }



    /*----------------------------------------*
     * Queue
     *----------------------------------------*/

    /**
     * メール送信処理をQueueに登録する
     * $delayがnullでない場合は、メール送信処理を指定した時間後に実行する
     * 
     * @param \DateTimeInterface|\DateInterval|int|null $delay
     * @return void
     */
    public function queue(\DateTimeInterface|\DateInterval|int|null $delay = null): void
    {
        // Mailクラスを生成する
        $mail = $this->getQueueMailInstance();

        // PendingMailクラスを生成する
        $pendingMail = $this->getPendingMail();

        // メール送信処理をQueueに登録する
        // $delayがnullの場合は、PendingMail::queue()を使用する
        // $delayがnull以外の場合は、PendingMail::later()を使用する
        is_null($delay)
            ? $pendingMail->queue($mail)
            : $pendingMail->later($delay, $mail);
    }

    /**
     * Queueに登録するMailerインスタンスを生成する
     * 
     * @return \LaravelMail\LaravelMail
     */
    protected function getQueueMailInstance(): LaravelMail
    {
        $mail = $this->getMailInstance();

        // MailにQueueに登録する際のConnection名を設定する
        $mail = $mail->onConnection($this->queueConnection());

        // MailにQueueに登録する際のQueue名を設定する
        $mail = $mail->onQueue($this->queueName());

        // MailにQueueに登録する処理をTransactionのCommit後に実行するかどうかを設定する
        if ($this->afterCommit()) $mail = $mail->afterCommit();

        return $mail;
    }

    /**
     * メールをQueueに登録する処理をTransactionのCommit後に実行するかどうかを取得する
     * 
     * @return bool
     */
    public function afterCommit(): bool
    {
        return $this->queueAfterCommit;
    }

    /**
     * メールをQueueに登録する処理をTransactionのCommit後に実行する
     * 
     * @param bool $queueAfterCommit
     * @return static
     */
    public function setAfterCommit(bool $queueAfterCommit = true): static
    {
        $this->queueAfterCommit = $queueAfterCommit;

        return $this;
    }

    /**
     * メールをQueueに登録する際のConnection名を取得する
     * 
     * @return ?string
     */
    public function queueConnection(): ?string
    {
        return $this->queueConnection;
    }

    /**
     * メールをQueueに登録する際のConnection名を設定する
     * 
     * @param string $queueConnection
     * @return static
     */
    public function onConnection(string $queueConnection): static
    {
        $this->queueConnection = $queueConnection;

        return $this;
    }

    /**
     * メールをQueueに登録する際のQueue名を取得する
     * 
     * @return ?string
     */
    public function queueName(): ?string
    {
        return $this->queueName;
    }

    /**
     * メールをQueueに登録する際のQueue名を設定する
     * 
     * @param string $queueName
     * @return static
     */
    public function onQueue(string $queueName): static
    {
        $this->queueName = $queueName;

        return $this;
    }
}
