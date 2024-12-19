@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-ungu focus:ring-ungu rounded-md shadow-sm']) }}>
