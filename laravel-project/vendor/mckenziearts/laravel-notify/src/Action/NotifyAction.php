<?php

declare(strict_types=1);

namespace Mckenziearts\Notify\Action;

use Mckenziearts\Notify\Exceptions\InvalidNotificationException;

final class NotifyAction
{
    private ?string $label = null;

    private ?string $action = null;

    private ?string $url = null;

    private ?string $classes = null;

    private ?string $method = null;

    private bool $openUrlInNewTab = false;

    private function __construct() {}

    public static function make(): self
    {
        return new self;
    }

    public function label(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function action(string $action): self
    {
        if ($this->url !== null) {
            throw new InvalidNotificationException(
                'Cannot use both action() and url(). Choose one or the other.'
            );
        }

        $this->action = $action;

        return $this;
    }

    public function url(string $url): self
    {
        if ($this->action !== null) {
            throw new InvalidNotificationException(
                'Cannot use both url() and action(). Choose one or the other.'
            );
        }

        $this->url = $url;

        return $this;
    }

    public function classes(string $classes): self
    {
        $this->classes = $classes;

        return $this;
    }

    public function method(string $method): self
    {
        if ($this->url !== null) {
            throw new InvalidNotificationException(
                'The method() function can only be used with action(), not with url().'
            );
        }

        $this->method = strtoupper($method);

        return $this;
    }

    public function openUrlInNewTab(bool $openInNewTab = true): self
    {
        if ($this->action !== null) {
            throw new InvalidNotificationException(
                'The openUrlInNewTab() function can only be used with url(), not with action().'
            );
        }

        $this->openUrlInNewTab = $openInNewTab;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getAction(): ?string
    {
        return $this->action;
    }

    public function getClasses(): ?string
    {
        return $this->classes;
    }

    public function getMethod(): ?string
    {
        return $this->method;
    }

    public function shouldOpenUrlInNewTab(): bool
    {
        return $this->openUrlInNewTab;
    }

    public function hasUrl(): bool
    {
        return $this->url !== null;
    }

    public function hasAction(): bool
    {
        return $this->action !== null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'label' => $this->label,
            'url' => $this->url,
            'action' => $this->action,
            'classes' => $this->classes,
            'method' => $this->action !== null ? ($this->method ?? 'POST') : null,
            'openUrlInNewTab' => $this->openUrlInNewTab,
        ];
    }
}
