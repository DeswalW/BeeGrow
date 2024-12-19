<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex justify-center items-center px-4 py-2 bg-ungu border border-transparent rounded-full font-medium text-sm text-white hover:bg-ungu/80 focus:bg-ungu/80 active:bg-ungu/90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>