<button {{ $attributes->merge(['type' => 'submit', 'class' => 'w-full inline-flex justify-center items-center px-4 py-2 bg-white border-2 border-ungu rounded-full font-medium text-sm text-ungu hover:bg-ungu hover:text-white focus:bg-ungu/80 active:bg-ungu/90 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>