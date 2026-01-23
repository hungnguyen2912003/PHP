<?php

declare(strict_types=1);

namespace Mckenziearts\Notify;

use Exception;
use Illuminate\Session\Store;
use Mckenziearts\Notify\Action\NotifyAction;
use Mckenziearts\Notify\Enums\NotificationModel;
use Mckenziearts\Notify\Enums\NotificationType;
use Mckenziearts\Notify\Exceptions\InvalidNotificationException;
use Mckenziearts\Notify\Exceptions\MissingPresetNotificationException;

final class Notify
{
    private ?NotificationType $type = null;

    private ?string $message = null;

    private ?string $title = null;

    private ?string $icon = null;

    private NotificationModel $model = NotificationModel::Toast;

    private ?int $duration = null;

    /**
     * @var array<NotifyAction>
     */
    private array $actions = [];

    public function __construct(
        private readonly Store $session
    ) {}

    public function success(): self
    {
        $this->type = NotificationType::Success;

        return $this;
    }

    public function error(): self
    {
        $this->type = NotificationType::Error;

        return $this;
    }

    public function warning(): self
    {
        $this->type = NotificationType::Warning;

        return $this;
    }

    public function info(): self
    {
        $this->type = NotificationType::Info;

        return $this;
    }

    public function model(NotificationModel $model): self
    {
        $this->model = $model;

        return $this;
    }

    public function message(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function title(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function icon(string $icon): self
    {
        $this->icon = $icon;

        return $this;
    }

    public function duration(int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * @param  array<int, NotifyAction>  $actions
     */
    public function actions(array $actions): self
    {
        $this->actions = $actions;

        return $this;
    }

    /**
     * Send the notification to the session
     *
     * @throws InvalidNotificationException
     */
    public function send(): void
    {
        $this->validate();

        $type = $this->type ?? NotificationType::Info;
        $icon = $this->icon ?? $type->getDefaultIcon($this->model);
        $title = $this->model === NotificationModel::Drake ? null : ($this->title ?? $type->getDefaultTitle());
        $duration = $this->duration ?? config('notify.timeout', 5000);

        $this->session->flash('notify', [
            'message' => $this->message,
            'type' => $type,
            'icon' => $icon,
            'model' => $this->model,
            'title' => $title,
            'duration' => $duration,
            'actions' => array_map(fn (NotifyAction $action): array => $action->toArray(), $this->actions),
        ]);

        $this->reset();
    }

    private function validate(): void
    {
        if ($this->model === NotificationModel::Drake) {
            if (filled($this->title)) {
                throw new InvalidNotificationException(
                    'The Drake notification cannot have a title. Remove ->title() call.'
                );
            }

            if (filled($this->message)) {
                throw new InvalidNotificationException(
                    'The Drake notification cannot have a message. Remove ->message() call.'
                );
            }

            if (filled($this->actions)) {
                throw new InvalidNotificationException(
                    'The Drake notification cannot have actions. Remove ->actions() call.'
                );
            }
        }

        // Validate that all actions have labels
        foreach ($this->actions as $action) {
            if (blank($action->getLabel())) {
                throw new InvalidNotificationException(
                    'All notification actions must have a label. Use ->label() method on NotifyAction.'
                );
            }
        }
    }

    /**
     * Return a preset message that is defined in the config file
     *
     * @param  array<string, mixed>  $overrideValues
     *
     * @throws Exception
     */
    public function preset(string $presetName, array $overrideValues = []): self
    {
        /** @var array<string, mixed>|null $presetValues */
        $presetValues = config('notify.preset-messages.'.$presetName);

        if (! $presetValues) {
            throw new MissingPresetNotificationException('A preset message does not exist with the name: '.$presetName);
        }

        if (isset($overrideValues['message']) || isset($presetValues['message'])) {
            /** @var string $message */
            $message = $overrideValues['message'] ?? $presetValues['message'];
            $this->message($message);
        }

        if (isset($overrideValues['title']) || isset($presetValues['title'])) {
            /** @var string $title */
            $title = $overrideValues['title'] ?? $presetValues['title'];
            $this->title($title);
        }

        if (isset($overrideValues['icon']) || isset($presetValues['icon'])) {
            /** @var string $icon */
            $icon = $overrideValues['icon'] ?? $presetValues['icon'];
            $this->icon($icon);
        }

        if (isset($overrideValues['type']) || isset($presetValues['type'])) {
            /** @var NotificationType|string $typeValue */
            $typeValue = $overrideValues['type'] ?? $presetValues['type'];
            $this->type = $typeValue instanceof NotificationType
                ? $typeValue
                : NotificationType::from($typeValue);
        }

        if (isset($overrideValues['model']) || isset($presetValues['model'])) {
            /** @var NotificationModel|string $modelValue */
            $modelValue = $overrideValues['model'] ?? $presetValues['model'];
            $this->model = $modelValue instanceof NotificationModel
                ? $modelValue
                : NotificationModel::from($modelValue);
        }

        if (isset($overrideValues['duration']) || isset($presetValues['duration'])) {
            /** @var int $duration */
            $duration = $overrideValues['duration'] ?? $presetValues['duration'];
            $this->duration($duration);
        }

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->session->get('notify.message'); // @phpstan-ignore-line return.type
    }

    public function getType(): ?NotificationType
    {
        return $this->session->get('notify.type'); // @phpstan-ignore-line return.type
    }

    private function reset(): void
    {
        $this->type = null;
        $this->message = null;
        $this->title = null;
        $this->icon = null;
        $this->model = NotificationModel::Toast;
        $this->duration = null;
        $this->actions = [];
    }
}
