<?php

namespace LaravelMail\Trait;

use Illuminate\Mail\Mailables\Content as MailContent;

/**
 * content()メソッドで使用するContentクラスを生成する処理を管理する
 * 
 * @package LaravelMail\Trait
 */
trait Content
{
    /**
     * 使用するviewのbladeファイル名
     * 
     * @var ?string
     */
    protected ?string $view = null;

    /**
     * 使用するviewのbladeファイル名
     * $viewの代替構文
     * 
     * @var ?string
     */
    protected ?string $html = null;

    /**
     * 使用するテキスト
     * 
     * @var ?string
     */
    protected ?string $text = null;

    /**
     * 使用するMarkdown
     * 
     * @var ?string
     */
    protected ?string $markdown = null;

    /**
     * 使用するHTML
     * 
     * @var ?string
     */
    protected ?string $htmlString = null;

    /**
     * viewで使用するデータ
     * 
     * @var array<string, mixed>
     */
    protected array $with = [];


    /**
     * Contentクラスを生成する
     * 
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function getContent(): MailContent
    {
        $content = new MailContent();

        // view
        $content = $this->setContentView($content);

        // html
        $content = $this->setContentHtml($content);

        // text
        $content = $this->setContentText($content);

        // markdown
        $content = $this->setContentMarkdown($content);

        // htmlString
        $content = $this->setContentHtmlString($content);

        // with
        $content = $this->setContentWith($content);

        return $content;
    }



    /*----------------------------------------*
     * View
     *----------------------------------------*/

    /**
     * 使用するviewのbladeファイル名を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentView(MailContent $content): MailContent
    {
        $view = $this->view();

        if (empty($view)) return $content;

        return $content->view($view);
    }

    /**
     * 使用するviewのbladeファイル名を取得する
     * 
     * @return ?string
     */
    public function view(): ?string
    {
        return $this->view;
    }

    /**
     * 使用するviewのbladeファイル名を設定する
     * 
     * @param string $view
     * @return static
     */
    public function setView(string $view): static
    {
        $this->view = $view;

        return $this;
    }



    /*----------------------------------------*
     * HTML
     *----------------------------------------*/

    /**
     * 使用するviewのbladeファイル名を設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentHtml(MailContent $content): MailContent
    {
        $html = $this->html();

        if (empty($html)) return $content;

        return $content->html($html);
    }

    /**
     * 使用するviewのbladeファイル名を取得する
     * 
     * @return ?string
     */
    public function html(): ?string
    {
        return $this->html;
    }

    /**
     * 使用するviewのbladeファイル名を設定する
     * 
     * @param string $view
     * @return static
     */
    public function setHtml(string $html): static
    {
        $this->html = $html;

        return $this;
    }



    /*----------------------------------------*
     * Text
     *----------------------------------------*/

    /**
     * 使用するテキストを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentText(MailContent $content): MailContent
    {
        $text = $this->text();

        if (empty($text)) return $content;

        return $content->text($text);
    }

    /**
     * 使用するテキストを取得する
     * 
     * @return ?string
     */
    public function text(): ?string
    {
        return $this->text;
    }

    /**
     * 使用するテキストを設定する
     * 
     * @param string $text
     * @return static
     */
    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }



    /*----------------------------------------*
     * Markdown
     *----------------------------------------*/

    /**
     * 使用するMarkdownを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentMarkdown(MailContent $content): MailContent
    {
        $markdown = $this->markdown();

        if (empty($markdown)) return $content;

        return $content->markdown($markdown);
    }

    /**
     * 使用するMarkdownを取得する
     * 
     * @return ?string
     */
    public function markdown(): ?string
    {
        return $this->markdown;
    }

    /**
     * 使用するMarkdownを設定する
     * 
     * @param string $markdown
     * @return static
     */
    public function setMarkdown(string $markdown): static
    {
        $this->markdown = $markdown;

        return $this;
    }



    /*----------------------------------------*
     * HTMLString
     *----------------------------------------*/

    /**
     * 使用するHTMLを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentHtmlString(MailContent $content): MailContent
    {
        $htmlString = $this->htmlString();

        if (empty($htmlString)) return $content;

        return $content->htmlString($htmlString);
    }

    /**
     * 使用するHTMLを取得する
     * 
     * @return ?string
     */
    public function htmlString(): ?string
    {
        return $this->htmlString;
    }

    /**
     * 使用するHTMLを設定する
     * 
     * @param string $htmlString
     * @return static
     */
    public function setHtmlString(string $htmlString): static
    {
        $this->htmlString = $htmlString;

        return $this;
    }



    /*----------------------------------------*
     * With
     *----------------------------------------*/

    /**
     * viewで使用するデータを設定する
     * 
     * @param \Illuminate\Mail\Mailables\Content $content
     * @return \Illuminate\Mail\Mailables\Content
     */
    protected function setContentWith(MailContent $content): MailContent
    {
        $with = $this->with();

        if (empty($with)) return $content;

        return $content->with($with);
    }

    /**
     * viewで使用するデータを取得する
     * 
     * @return array<string, mixed>
     */
    public function with(): array
    {
        return $this->with;
    }

    /**
     * viewで使用するデータを設定する
     * 
     * @param array<string, mixed> $with
     * @return static
     */
    public function setWith(array $with): static
    {
        $this->with = $with;

        return $this;
    }
}
