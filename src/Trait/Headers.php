<?php

namespace LaravelMail\Trait;

use Illuminate\Mail\Mailables\Headers as MailHeaders;

/**
 * headers()メソッドで使用するHeadersクラスの配列を生成する処理を管理する
 * 
 * @package LaravelMail\Trait
 */
trait Headers
{
    /**
     * メッセージID
     * 
     * @var ?string
     */
    protected ?string $messageId = null;

    /**
     * リファレンスの配列
     * 
     * @var array<int, string>
     */
    protected array $references = [];

    /**
     * テキストヘッダーの配列
     * 
     * @var array<string, string>
     */
    protected array $textHeaders = [];


    /**
     * Attachmentクラスの配列を生成する
     * 
     * @return \Illuminate\Mail\Mailables\Headers
     */
    protected function getHeaders(): MailHeaders
    {
        $headers = new MailHeaders();

        // メッセージID
        $headers = $this->setHeadersMessageId($headers);

        // リファレンス
        $headers = $this->setHeadersReferences($headers);

        // テキストヘッダー
        $headers = $this->setHeadersTextHeaders($headers);

        return $headers;
    }



    /*----------------------------------------*
     * Message ID
     *----------------------------------------*/

    /**
     * メッセージIDを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Headers $headers
     * @return \Illuminate\Mail\Mailables\Headers
     */
    protected function setHeadersMessageId(MailHeaders $headers): MailHeaders
    {
        $messageId = $this->messageId();

        if (empty($messageId)) return $headers;

        return $headers->messageId($messageId);
    }

    /**
     * メッセージIDを取得する
     * 
     * @return ?string
     */
    public function messageId(): ?string
    {
        return $this->messageId;
    }

    /**
     * メッセージIDを設定する
     * 
     * @param string $messageId
     * @return static
     */
    public function setMessageId(string $messageId): static
    {
        $this->messageId = $messageId;

        return $this;
    }



    /*----------------------------------------*
     * References
     *----------------------------------------*/

    /**
     * リファレンスの配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Headers $headers
     * @return \Illuminate\Mail\Mailables\Headers
     */
    protected function setHeadersReferences(MailHeaders $headers): MailHeaders
    {
        $references = $this->references();

        if (empty($references)) return $headers;

        return $headers->references($references);
    }

    /**
     * リファレンスの配列を取得する
     * 
     * @return array<int, string>
     */
    public function references(): array
    {
        return $this->references;
    }

    /**
     * リファレンスの配列を設定する
     * 
     * @param array<int, string> $references
     * @return static
     */
    public function setReferences(array $references): static
    {
        $this->references = $references;

        return $this;
    }

    /**
     * リファレンスを追加する
     * 
     * @param string $reference
     * @return static
     */
    public function addReferences(string $reference): static
    {
        $this->references[] = $reference;

        return $this;
    }



    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * テキストヘッダーの配列を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Headers $headers
     * @return \Illuminate\Mail\Mailables\Headers
     */
    protected function setHeadersTextHeaders(MailHeaders $headers): MailHeaders
    {
        $textHeaders = $this->textHeaders();

        if (empty($textHeaders)) return $headers;

        return $headers->text($textHeaders);
    }

    /**
     * テキストヘッダーの配列を取得する
     * 
     * @return array<string, string>
     */
    public function textHeaders(): array
    {
        return $this->textHeaders;
    }

    /**
     * テキストヘッダーの配列を設定する
     * 
     * @param array<string, string> $textHeaders
     * @return static
     */
    public function setTextHeaders(array $textHeaders): static
    {
        $this->textHeaders = $textHeaders;

        return $this;
    }

    /**
     * テキストヘッダーを追加する
     * 
     * @param string $key
     * @param string $value
     * @return static
     */
    public function addTextHeaders(string $key, string $value): static
    {
        $this->textHeaders[$key] = $value;

        return $this;
    }
}
