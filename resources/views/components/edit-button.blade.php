<a {{ $attributes->merge([
    'class' =>
        'tw-inline-flex tw-items-center tw-p-2 tw-bg-yellow-500 tw-border tw-border-transparent tw-rounded-md tw-font-semibold tw-text-xs tw-text-white tw-uppercase tw-tracking-widest hover:tw-bg-yellow-300 focus:tw-bg-yellow-300 active:tw-bg-yellow-500 focus:tw-outline-none focus:tw-ring-2 focus:tw-ring-indigo-500 focus:tw-ring-offset-2 tw-transition tw-ease-in-out tw-duration-150'
]) }}>
    {{ $slot }}
</a>