<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-navbar', 'data-widget' => '']) }}>
    {{ $slot }}
</button>
