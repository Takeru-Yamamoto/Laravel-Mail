<?php

namespace LaravelMail\Trait;

use Illuminate\Mail\Mailables\Attachment as MailAttachment;

/**
 * attachments()メソッドで使用するAttachmentクラスの配列を生成する処理を管理する
 * 
 * @package LaravelMail\Trait
 */
trait Attachments
{
    /**
     * 添付ファイルの配列
     * 
     * @var array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    protected array $attachments = [];


    /**
     * Attachmentクラスの配列を生成する
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    protected function getAttachments(): array
    {
        return $this->attachments();
    }

    /**
     * Attachmentインスタンスを生成する
     * 
     * @param \Illuminate\Mail\Mailables\Attachment $attachment
     * @param string|null $name
     * @param string|null $mime
     * @return \Illuminate\Mail\Mailables\Attachment
     */
    protected function getAttachmentInstance(MailAttachment $attachment, ?string $name = null, ?string $mime = null): MailAttachment
    {
        // ファイル名が指定されている場合は設定する
        if (!empty($name)) $attachment = $attachment->as($name);

        // MIMEタイプが指定されている場合は設定する
        if (!empty($mime)) $attachment = $attachment->withMime($mime);

        return $attachment;
    }


    /**
     * 添付ファイルを取得する
     * 
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return $this->attachments;
    }

    /**
     * 添付ファイルを設定する
     * 
     * @param array<int, \Illuminate\Mail\Mailables\Attachment>
     * @return static
     */
    public function setAttachments(array $attachments): static
    {
        $this->attachments = $attachments;

        return $this;
    }

    /**
     * 添付ファイルを追加する
     * 
     * @param \Illuminate\Mail\Mailables\Attachment $attachment
     * @return static
     */
    public function addAttachments(MailAttachment $attachment): static
    {
        $this->attachments[] = $attachment;

        return $this;
    }

    /**
     * ファイルパスを使用して添付ファイルを追加する
     * 
     * @param string $path
     * @param string|null $name
     * @param string|null $mime
     * @return static
     */
    public function addAttachmentsFromPath(string $path, ?string $name = null, ?string $mime = null): static
    {
        return $this->addAttachment($this->getAttachmentInstance(
            MailAttachment::fromPath($path),
            $name,
            $mime
        ));
    }

    /**
     * ファイルパスを使用してStorage配下の添付ファイルを追加する
     * 
     * @param string $path
     * @param string|null $name
     * @param string|null $mime
     * @return static
     */
    public function addAttachmentsFromStorage(string $path, ?string $name = null, ?string $mime = null): static
    {
        return $this->addAttachment($this->getAttachmentInstance(
            MailAttachment::fromStorage($path),
            $name,
            $mime
        ));
    }

    /**
     * ファイルパスとディスク名を使用してStorage配下の添付ファイルを追加する
     * 
     * @param string $path
     * @param string $disk
     * @param string|null $name
     * @param string|null $mime
     * @return static
     */
    public function addAttachmentsFromStorageDisk(string $path, string $disk, ?string $name = null, ?string $mime = null): static
    {
        return $this->addAttachment($this->getAttachmentInstance(
            MailAttachment::fromStorageDisk($disk, $path),
            $name,
            $mime
        ));
    }

    /**
     * ファイルパスを使用して添付ファイルを追加する
     * 
     * @param \Closure $data
     * @param string|null $name
     * @param string|null $mime
     * @return static
     */
    public function addAttachmentsFromData(\Closure $data, ?string $name = null, ?string $mime = null): static
    {
        return $this->addAttachment($this->getAttachmentInstance(
            MailAttachment::fromData($data),
            $name,
            $mime
        ));
    }
}
