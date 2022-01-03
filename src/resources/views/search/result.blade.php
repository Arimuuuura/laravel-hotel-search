<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Search Result
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-search.container>
                        @foreach($hotels as $hotel)
                            @foreach($hotel as $val)
                                <div class="p-4 md:w-1/4 sm:mb-0 mb-6">
                                    <div class="rounded-lg h-48 overflow-hidden">
                                        <img alt="content" class="object-cover object-center h-full w-full" src="{{ $val[0]["hotelBasicInfo"]["hotelThumbnailUrl"] }}">
                                    </div>
                                    <p class="text-base leading-relaxed mt-2">{{ $val[0]["hotelBasicInfo"]["hotelName"] }}</p>
                                    <a href="{{ $val[0]["hotelBasicInfo"]["planListUrl"] }}" class="text-indigo-500 inline-flex items-center mt-3">Learn More</a>
                                </div>
                            @endforeach
                        @endforeach
                    </x-search.container>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
