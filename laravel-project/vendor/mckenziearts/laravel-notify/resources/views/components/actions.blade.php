@php
    $actions = session()->get('notify.actions', []);
@endphp

@if (count($actions) > 0)
    <div {{ $attributes->merge(['class' => 'mt-3 flex gap-6']) }}>
        @foreach ($actions as $action)
            @if (isset($action['url']))
                <a
                    href="{{ $action['url'] }}"
                    @if ($action['openUrlInNewTab'] ?? false) target="_blank" rel="noopener noreferrer" @endif
                    @class([
                        'rounded-md text-sm font-medium',
                        $action['classes'] ?? 'text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300'
                    ])
                >
                    {{ $action['label'] }}
                </a>
            @elseif (isset($action['action']))
                <button
                    type="button"
                    x-on:click="
                        fetch('{{ $action['action'] }}', {
                            method: '{{ $action['method'] ?? 'POST' }}',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json',
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(response => {
                            if (response.ok) {
                                show = false;
                            }
                        })
                        .catch(error => console.error('Error:', error));
                    "
                    @class([
                        'rounded-md text-sm font-medium cursor-pointer',
                        $action['classes'] ?? 'text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300'
                    ])
                >
                    {{ $action['label'] }}
                </button>
            @endif
        @endforeach
    </div>
@endif
