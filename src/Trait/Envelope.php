<?php

namespace LaravelMail\Trait;

use Illuminate\Mail\Mailables\Envelope as MailEnvelope;

use Illuminate\Mail\Mailables\Address;

/**
 * envelope()メソッドで使用するEnvelopeクラスを生成する処理を管理する
 * 
 * @package LaravelMail\Trait
 */
trait Envelope
{
    /**
     * 送信元メールアドレス
     * 
     * @var ?string
     */
    protected ?string $senderAddress = null;

    /**
     * 送信元名
     * 
     * @var ?string
     */
    protected ?string $senderName = null;

    /**
     * 送信先メールアドレス
     * 
     * @var ?string
     */
    protected ?string $recipientAddress = null;

    /**
     * 送信先名
     * 
     * @var ?string
     */
    protected ?string $recipientName = null;

    /**
     * 件名
     * 
     * @var ?string
     */
    protected ?string $subject = null;

    /**
     * CCのメールアドレスと名前の配列
     * 
     * @var array<int, \Illuminate\Mail\Mailables\Address>
     */
    protected array $cc = [];

    /**
     * BCCのメールアドレスと名前の配列
     * 
     * @var array<int, \Illuminate\Mail\Mailables\Address>
     */
    protected array $bcc = [];

    /**
     * ReplyToのメールアドレスと名前の配列
     * 
     * @var array<int, \Illuminate\Mail\Mailables\Address>
     */
    protected array $replyTo = [];

    /**
     * タグの配列
     * 
     * @var array<int, string>
     */
    protected array $tags = [];

    /**
     * メタデータの配列
     * 
     * @var array<string, string|int>
     */
    protected array $metadata = [];


    /**
     * Envelopeクラスを生成する
     * 
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function getEnvelope(): MailEnvelope
    {
        $envelope = new MailEnvelope();

        // 送信先
        $envelope = $this->setEnvelopeSender($envelope);

        // 送信元
        $envelope = $this->setEnvelopeRecipient($envelope);

        // 件名
        $envelope = $this->setEnvelopeSubject($envelope);

        // CC
        $envelope = $this->setEnvelopeCc($envelope);

        // BCC
        $envelope = $this->setEnvelopeBcc($envelope);

        // ReplyTo
        $envelope = $this->setEnvelopeReplyTo($envelope);

        // Tags
        $envelope = $this->setEnvelopeTags($envelope);

        // Metadata
        $envelope = $this->setEnvelopeMetadata($envelope);

        return $envelope;
    }

    /**
     * Addressインスタンスを生成する
     * 
     * @param string $address
     * @param ?string $name
     * @return \Illuminate\Mail\Mailables\Address
     */
    protected function getAddressInstance(string $address, ?string $name = null): Address
    {
        return empty($name) ? new Address($address) : new Address($address, $name);
    }



    /*----------------------------------------*
     * Sender
     *----------------------------------------*/

    /**
     * 送信元のAddressインスタンスを設定する
     *
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeSender(MailEnvelope $envelope): MailEnvelope
    {
        $senderAddress = $this->senderAddress();
        $senderName    = $this->senderName();

        if (empty($senderAddress)) return $envelope;

        $address = $this->getAddressInstance($senderAddress, $senderName);

        return $envelope->from($address);
    }

    /**
     * 送信元メールアドレスを取得する
     * 
     * @return ?string
     */
    public function senderAddress(): ?string
    {
        return empty($this->senderAddress) ? config("mail.from.address") : $this->senderAddress;
    }

    /**
     * 送信元メールアドレスを設定する
     * 
     * @param string $senderAddress
     * @return static
     */
    public function setSenderAddress(string $senderAddress): static
    {
        $this->senderAddress = $senderAddress;

        return $this;
    }

    /**
     * 送信元名を取得する
     * 
     * @return ?string
     */
    public function senderName(): ?string
    {
        return empty($this->senderName) ? config("mail.from.name") : $this->senderName;
    }

    /**
     * 送信元名を設定する
     * 
     * @param string $senderName
     * @return static
     */
    public function setSenderName(string $senderName): static
    {
        $this->senderName = $senderName;

        return $this;
    }



    /*----------------------------------------*
     * To
     *----------------------------------------*/

    /**
     * 送信先のAddressインスタンスを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeRecipient(MailEnvelope $envelope): MailEnvelope
    {
        $recipientAddress = $this->recipientAddress();
        $recipientName    = $this->recipientName();

        if (empty($recipientAddress)) return $envelope;

        $address = $this->getAddressInstance($recipientAddress, $recipientName);

        return $envelope->to($address);
    }

    /**
     * 送信先メールアドレスを取得する
     * 
     * @return ?string
     */
    public function recipientAddress(): ?string
    {
        return $this->recipientAddress;
    }

    /**
     * 送信先メールアドレスを設定する
     * 
     * @param string $recipientAddress
     * @return static
     */
    public function setRecipientAddress(string $recipientAddress): static
    {
        $this->recipientAddress = $recipientAddress;

        return $this;
    }

    /**
     * 送信先名を取得する
     * 
     * @return ?string
     */
    public function recipientName(): ?string
    {
        return $this->recipientName;
    }

    /**
     * 送信先名を設定する
     * 
     * @param string $recipientName
     * @return static
     */
    public function setRecipientName(string $recipientName): static
    {
        $this->recipientName = $recipientName;

        return $this;
    }



    /*----------------------------------------*
     * Subject
     *----------------------------------------*/

    /**
     * 件名を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeSubject(MailEnvelope $envelope): MailEnvelope
    {
        $subject = $this->subject();

        if (empty($subject)) return $envelope;

        return $envelope->subject($subject);
    }

    /**
     * 件名を取得する
     * 
     * @return ?string
     */
    public function subject(): ?string
    {
        return $this->subject;
    }

    /**
     * 件名を設定する
     * 
     * @param string $subject
     * @return static
     */
    public function setSubject(string $subject): static
    {
        $this->subject = $subject;

        return $this;
    }



    /*----------------------------------------*
     * CC
     *----------------------------------------*/

    /**
     * CCのAddressインスタンスが格納された配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeCc(MailEnvelope $envelope): MailEnvelope
    {
        $cc = $this->cc();

        if (empty($cc)) return $envelope;

        return $envelope->cc($cc);
    }

    /**
     * CCのAddressインスタンスが格納された配列を取得する
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Address>
     */
    public function cc(): array
    {
        return $this->cc;
    }

    /**
     * CCのメールアドレスと名前の配列を設定する
     * 
     * @param array<int, \Illuminate\Mail\Mailables\Address> $cc
     * @return static
     */
    public function setCc(array $cc): static
    {
        $this->cc = $cc;

        return $this;
    }

    /**
     * CCのメールアドレスと名前を追加する
     * 
     * @param string $ccAddress
     * @param ?string $ccName
     * @return static
     */
    public function addCc(string $ccAddress, ?string $ccName = null): static
    {
        $this->cc[] = $this->getAddressInstance($ccAddress, $ccName);

        return $this;
    }



    /*----------------------------------------*
     * BCC
     *----------------------------------------*/

    /**
     * BCCのAddressインスタンスが格納された配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeBcc(MailEnvelope $envelope): MailEnvelope
    {
        $bcc = $this->bcc();

        if (empty($bcc)) return $envelope;

        return $envelope->bcc($bcc);
    }

    /**
     * BCCのメールアドレスと名前の配列を取得する
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Address>
     */
    public function bcc(): array
    {
        return $this->bcc;
    }

    /**
     * BCCのメールアドレスと名前の配列を設定する
     * 
     * @param array<int, \Illuminate\Mail\Mailables\Address> $bcc
     * @return static
     */
    public function setBcc(array $bcc): static
    {
        $this->bcc = $bcc;

        return $this;
    }

    /**
     * BCCのメールアドレスと名前を追加する
     * 
     * @param string $bccAddress
     * @param ?string $bccName
     * @return static
     */
    public function addBcc(string $bccAddress, ?string $bccName = null): static
    {
        $this->bcc[] = $this->getAddressInstance($bccAddress, $bccName);

        return $this;
    }



    /*----------------------------------------*
     * ReplyTo
     *----------------------------------------*/

    /**
     * ReplyToのAddressインスタンスが格納された配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeReplyTo(MailEnvelope $envelope): MailEnvelope
    {
        $replyTo = $this->replyTo();

        if (empty($replyTo)) return $envelope;

        return $envelope->replyTo($replyTo);
    }

    /**
     * ReplyToのメールアドレスと名前の配列を取得する
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Address>
     */
    public function replyTo(): array
    {
        return $this->replyTo;
    }

    /**
     * ReplyToのメールアドレスと名前の配列を設定する
     * 
     * @param array<int, \Illuminate\Mail\Mailables\Address> $replyTo
     * @return static
     */
    public function setReplyTo(array $replyTo): static
    {
        $this->replyTo = $replyTo;

        return $this;
    }

    /**
     * ReplyToのメールアドレスと名前を追加する
     * 
     * @param string $replyToAddress
     * @param ?string $replyToName
     * @return static
     */
    public function addReplyTo(string $replyToAddress, ?string $replyToName = null): static
    {
        $this->replyTo[] = $this->getAddressInstance($replyToAddress, $replyToName);

        return $this;
    }



    /*----------------------------------------*
     * Tags
     *----------------------------------------*/

    /**
     * タグの配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeTags(MailEnvelope $envelope): MailEnvelope
    {
        $tags = $this->tags();

        if (empty($tags)) return $envelope;

        return $envelope->tags($tags);
    }

    /**
     * タグの配列を取得する
     * 
     * @return array<int, string>
     */
    public function tags(): array
    {
        return $this->tags;
    }

    /**
     * タグの配列を設定する
     * 
     * @param array<int, string> $tags
     * @return static
     */
    public function setTags(array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * タグを追加する
     * 
     * @param string $tag
     * @return static
     */
    public function addTags(string $tag): static
    {
        $this->tags[] = $tag;

        return $this;
    }



    /*----------------------------------------*
     * Metadata
     *----------------------------------------*/

    /**
     * メタデータの配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Envelope $envelope
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    protected function setEnvelopeMetadata(MailEnvelope $envelope): MailEnvelope
    {
        $metadata = $this->metadata();

        if (empty($metadata)) return $envelope;

        // メタデータは一つずつ設定する必要がある
        foreach ($metadata as $key => $value) {
            $envelope = $envelope->metadata($key, $value);
        }

        return $envelope;
    }

    /**
     * メタデータの配列を取得する
     * 
     * @return array<string, string|int>
     */
    public function metadata(): array
    {
        return $this->metadata;
    }

    /**
     * メタデータの配列を設定する
     * 
     * @param array<string, string|int> $metadata
     * @return static
     */
    public function setMetadata(array $metadata): static
    {
        $this->metadata = $metadata;

        return $this;
    }

    /**
     * メタデータを追加する
     * 
     * @param string $key
     * @param string|int $value
     * @return static
     */
    public function addMetadata(string $key, string|int $value): static
    {
        $this->metadata[$key] = $value;

        return $this;
    }
}
