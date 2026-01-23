<?php

declare(strict_types=1);

use Illuminate\Session\Store;
use Mckenziearts\Notify\Enums\NotificationModel;
use Mckenziearts\Notify\Enums\NotificationType;
use Mckenziearts\Notify\Exceptions\InvalidNotificationException;
use Mckenziearts\Notify\Exceptions\MissingPresetNotificationException;
use Mckenziearts\Notify\Notify;

/**
 * @var Tests\TestCase $this
 */
beforeEach(function (): void {
    $this->session = Mockery::mock(Store::class);
    $this->notify = new Notify($this->session);
});

afterEach(function (): void {
    Mockery::close();
});

it('can emit a notification and store it in session', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Success
            && $data['title'] === 'Success'
            && $data['model'] === NotificationModel::Toast));

    $this->notify
        ->success()
        ->title('Success')
        ->send();
});

it('can send notification with message', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['message'] === 'Operation completed successfully'));

    $this->notify
        ->success()
        ->title('Success')
        ->message('Operation completed successfully')
        ->send();
});

it('can create success notification', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Success));

    $this->notify->success()->send();
});

it('can create error notification', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Error));

    $this->notify->error()->send();
});

it('can create warning notification', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Warning));

    $this->notify->warning()->send();
});

it('can create info notification', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Info));

    $this->notify->info()->send();
});

it('defaults to info type when no type is specified', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Info));

    $this->notify->send();
});

it('defaults to toast model', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Toast));

    $this->notify->success()->send();
});

it('can use connect model', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Connect));

    $this->notify
        ->model(NotificationModel::Connect)
        ->success()
        ->send();
});

it('can use drake model', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Drake));

    $this->notify
        ->model(NotificationModel::Drake)
        ->success()
        ->send();
});

it('can use smiley model', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Smiley));

    $this->notify
        ->model(NotificationModel::Smiley)
        ->success()
        ->send();
});

it('can use emotify model', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Emotify));

    $this->notify
        ->model(NotificationModel::Emotify)
        ->success()
        ->send();
});

it('can set custom icon', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['icon'] === 'user'));

    $this->notify
        ->success()
        ->icon('user')
        ->send();
});

it('uses default icon when not specified', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['icon'] !== null));

    $this->notify->success()->send();
});

it('can set custom duration', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['duration'] === 3000));

    $this->notify
        ->success()
        ->duration(3000)
        ->send();
});

it('uses default duration from config when not specified', function (): void {
    config(['notify.timeout' => 5000]);

    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['duration'] === 5000));

    $this->notify->success()->send();
});

it('throws exception when drake model has title', function (): void {
    expect(fn () => $this->notify
        ->model(NotificationModel::Drake)
        ->title('Some title')
        ->send()
    )->toThrow(InvalidNotificationException::class, 'The Drake notification cannot have a title');
});

it('throws exception when drake model has message', function (): void {
    expect(fn () => $this->notify
        ->model(NotificationModel::Drake)
        ->message('Some message')
        ->send()
    )->toThrow(InvalidNotificationException::class, 'The Drake notification cannot have a message');
});

it('allows drake model without title and message', function (): void {
    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['model'] === NotificationModel::Drake
            && $data['title'] === null
            && $data['message'] === null));

    $this->notify
        ->model(NotificationModel::Drake)
        ->success()
        ->send();
});

it('throws exception when drake model has actions', function (): void {
    expect(fn () => $this->notify
        ->model(NotificationModel::Drake)
        ->actions([
            \Mckenziearts\Notify\Action\NotifyAction::make()
                ->label('Action')
                ->url('https://example.com'),
        ])
        ->send()
    )->toThrow(InvalidNotificationException::class, 'The Drake notification cannot have actions');
});

it('can load preset notification', function (): void {
    config([
        'notify.preset-messages.user-created' => [
            'type' => NotificationType::Success,
            'model' => NotificationModel::Toast,
            'title' => 'User Created',
            'message' => 'The user was created successfully',
        ],
    ]);

    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['type'] === NotificationType::Success
            && $data['model'] === NotificationModel::Toast
            && $data['title'] === 'User Created'
            && $data['message'] === 'The user was created successfully'));

    $this->notify->preset('user-created')->send();
});

it('can override preset values', function (): void {
    config([
        'notify.preset-messages.user-created' => [
            'type' => NotificationType::Success,
            'title' => 'User Created',
        ],
    ]);

    $this->session->shouldReceive('flash')
        ->once()
        ->with('notify', Mockery::on(fn (array $data): bool => $data['title'] === 'Custom Title'));

    $this->notify
        ->preset('user-created', ['title' => 'Custom Title'])
        ->send();
});

it('throws exception for missing preset', function (): void {
    expect(fn () => $this->notify->preset('non-existent')->send()
    )->toThrow(MissingPresetNotificationException::class);
});

it('resets state after sending notification', function (): void {
    $this->session->shouldReceive('flash')->twice();
    $this->session->shouldReceive('get')->with('notify.message')->andReturn(null);

    $this->notify
        ->success()
        ->title('First')
        ->message('First message')
        ->send();

    // Second notification should not inherit values from first
    $this->notify
        ->error()
        ->send();

    expect($this->notify->getMessage())->toBeNull();
});

it('supports method chaining', function (): void {
    $this->session->shouldReceive('flash')->once();

    $result = $this->notify
        ->success()
        ->title('Title')
        ->message('Message')
        ->icon('check')
        ->duration(3000)
        ->model(NotificationModel::Toast);

    expect($result)->toBeInstanceOf(Notify::class);

    $result->send();
});
