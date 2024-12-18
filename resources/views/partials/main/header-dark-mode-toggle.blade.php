<div class="relative w-24 h-12">
    <div class="mx-8 text-yellow-500 text-xl cursor-pointer h-10 w-10 rounded-full overflow-hidden absolute top-0 mt-1.5" x-show="darkMode" @click="darkMode = false" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform rotate-180 opacity-0"
        x-transition:enter-end=" transform rotate-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform rotate-0 opacity-100"
        x-transition:leave-end="transform rotate-180 opacity-0">

        <img src="{{ asset('img/dark-switch.png')}}" alt="" class="object-contain h-full">

    </div>

    <div class="mx-8 text-gray-600 text-xl cursor-pointer h-10 w-10 rounded-full overflow-hidden absolute top-0 mt-1.5" x-show="!darkMode" @click="darkMode = true"  x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="transform rotate-180 opacity-0"
        x-transition:enter-end=" transform rotate-0 opacity-100"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="transform rotate-0 opacity-100"
        x-transition:leave-end="transform rotate-180 opacity-0">

        <img src="{{ asset('img/light-switch.png')}}" alt="" class="object-contain h-full">

    </div>
</div>
