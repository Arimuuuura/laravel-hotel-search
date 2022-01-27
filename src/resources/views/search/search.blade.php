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
                    <x-search.select :areas="$areas" />
                    @if($hotels !== null)
                        <form method="post" action="{{ route('hotel.show') }}">
                            @csrf
                            <x-search.container>
                                @foreach($hotels as $hotel)
                                    @foreach($hotel as $val)
                                        <div class="p-4 md:w-1/4 sm:mb-0 mb-6">
                                            <div class="rounded-lg overflow-hidden">
                                                <img alt="content" class="object-cover object-center" src="{{ $val[0]["hotelBasicInfo"]["hotelImageUrl"] }}">
                                            </div>
                                            <p class="text-base leading-relaxed mt-2">{{ $val[0]["hotelBasicInfo"]["hotelName"] }}</p>
                                            <button class="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">Learn More</button>
                                            <input type="hidden" name="hotelName" value="{{ $val[0]["hotelBasicInfo"]["hotelName"] }}">
                                            <input type="hidden" name="hotelSpecial" value="{{ $val[0]["hotelBasicInfo"]["hotelSpecial"] }}">
                                            <input type="hidden" name="hotelImageUrl" value="{{ $val[0]["hotelBasicInfo"]["hotelImageUrl"] }}">
                                            <input type="hidden" name="hotelMinCharge" value="{{ $val[0]["hotelBasicInfo"]["hotelMinCharge"] }}">
                                            <input type="hidden" name="reviewAverage" value="{{ $val[0]["hotelBasicInfo"]["reviewAverage"] }}">
                                            <input type="hidden" name="userReview" value="{{ $val[0]["hotelBasicInfo"]["userReview"] }}">
                                            <input type="hidden" name="hotelInformationUrl" value="{{ $val[0]["hotelBasicInfo"]["hotelInformationUrl"] }}">
                                        </div>
                                    @endforeach
                                @endforeach
                            </x-search.container>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
