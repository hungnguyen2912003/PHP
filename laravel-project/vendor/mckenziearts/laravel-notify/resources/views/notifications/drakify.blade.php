@php
    use Mckenziearts\Notify\Enums\NotificationType;
    use Mckenziearts\Notify\Enums\NotificationModel;
@endphp

<x-notify::notification-wrapper :model="NotificationModel::Drake">
    <div class="h-36 relative rounded-lg overflow-hidden">
        @if (session()->get('notify.type') === NotificationType::Success)
            <img class="absolute inset-0" src="{{ asset('/vendor/mckenziearts/laravel-notify/images/drake-success.jpg') }}" alt="" />
            <div class="bg-green-500 absolute inset-0 opacity-75"></div>
        @else
            <img class="absolute inset-0" src="{{ asset('/vendor/mckenziearts/laravel-notify/images/drake-error.jpg') }}" alt="" />
            <div class="bg-red-500 absolute inset-0 opacity-75"></div>
        @endif

        <div class="p-4 relative z-10">
            @if (session()->get('notify.type') === NotificationType::Success)
                <div class="flex items-start justify-start h-full">
                    <span class="shrink-0 inline-flex items-center justify-center size-12 bg-white rounded-full">
                        @if (session()->get('notify.icon'))
                            <x-notify::icon
                                :name="session()->get('notify.icon')"
                                class="size-7 text-green-600"
                                aria-hidden="true"
                            />
                        @else
                            <x-untitledui-check class="size-7 text-green-600" aria-hidden="true" />
                        @endif
                    </span>
                </div>
            @else
                <div class="flex items-end justify-end h-full">
                    <span class="shrink-0 inline-flex items-center justify-center size-12 bg-white rounded-full">
                        @if (session()->get('notify.icon'))
                            <x-notify::icon
                                :name="session()->get('notify.icon')"
                                class="size-7 text-red-500"
                                aria-hidden="true"
                            />
                        @else
                            <x-untitledui-x class="size-7 text-red-500" aria-hidden="true" />
                        @endif
                    </span>
                </div>
            @endif
        </div>
    </div>
</x-notify::notification-wrapper>
