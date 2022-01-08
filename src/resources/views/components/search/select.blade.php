@php
    $areasJson = json_encode($areas);
    $small = \Request::get("small") ?? false;
    $detail = \Request::get("detail") ?? false;
@endphp
<form method="get" action="{{ route('hotel.search') }}">
    <div class="lg:flex lg:justify-around">
        <div class="lg:flex items-center">
            <div class="flex space-x-2 items-center">
                <div class="ml-6 items-center">
                    <span class="mr-3 text-xs text-gray-500">都道府県を選択</span>
                    <div class="relative">
                        <!--suppress HtmlFormInputWithoutLabel -->
                        <select name="middle" id="middle" class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                            <!--suppress CheckEmptyScriptTag -->
                            <optgroup label="都道府県を選択" />
                            <option value="">
                                未選択
                            </option>
                            @foreach($areas as $area)
                                <option value="{{ $area["middleClass"][0]["middleClassCode"] }}" @if(\Request::get("middle") === $area["middleClass"][0]["middleClassCode"]) selected @endif>
                                    {{ $area["middleClass"][0]["middleClassName"] }}
                                </option>
                            @endforeach
                        </select>
                        <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="ml-6 items-center">
                    <span class="mr-3 text-xs text-gray-500">エリアを選択</span>
                    <div class="relative">
                        <!--suppress HtmlFormInputWithoutLabel -->
                        <select name="small" id="small" disabled class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                        </select>
                        <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="ml-6 items-center">
                    <span class="mr-3 text-xs text-gray-500">詳細エリア</span>
                    <div class="relative">
                        <!--suppress HtmlFormInputWithoutLabel -->
                        <select name="detail" id="detail" disabled class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                        </select>
                        <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                <path d="M6 9l6 6 6-6"></path>
                            </svg>
                        </span>
                    </div>
                </div>
                <div><button id="hotel-search" type="submit" disabled class="ml-auto text-white bg-gray-300 border-0 py-2 px-6 focus:outline-none rounded">検索する</button></div>
            </div>
        </div>
    </div>
</form>

<script>
    'use strict';
    {
        const middle = document.getElementById('middle');
        const small = document.getElementById('small');
        const detail = document.getElementById('detail');
        const searchButton = document.getElementById('hotel-search');
        const smallEx = "<?= $small ?>";
        const detailEx = "<?= $detail ?>";
        const areas = <?= $areasJson ?>;

        const createOption = (area, code, name, className, city) => {
            const option = document.createElement('option');
            option.value = code;
            option.innerHTML = name;
            option.classList.add(className);
            optionSelected(option, city, code);
            area.appendChild(option);
        };

        const optionSelected = (option, city, code) => option.selected = city === code && true;

        const createOptgroup = () => {
            const optgroup = document.createElement('optgroup');
            optgroup.label = "地域を選択";
            small.appendChild(optgroup);
        };

        const removeOption = (className, area) => {
            const option = document.getElementsByClassName(className);
            if(option.length) {
                Array.from(option).forEach(node => area.removeChild(node));
            }
        };

        const classes = areas.map(val => {
            const {middleClass} = val;
            const [{middleClassCode, middleClassName}] = middleClass;
            // const smallClasses = middleClass.map((val, index) => {
            //     if(!index === 1) return;
            //     const {smallClasses} = val;
            //     return {smallClasses};
            // });
            return {middleClassCode, middleClassName};
        });

        const createSmallSelects = middleArea => {
            removeOption('small-option', small);
            small.disabled = false;

            areas.forEach((middleClasses, index) => {
                const {middleClassCode, middleClassName} = classes[index];
                const smalls = middleClasses["middleClass"][1]["smallClasses"];
                middleArea === middleClassCode && smalls.forEach(smallClasses => {
                    const smallCode = smallClasses["smallClass"][0]["smallClassCode"];
                    const smallName = smallClasses["smallClass"][0]["smallClassName"];
                    createOption(small, smallCode, smallName, 'small-option', smallEx);
                });
            });
        }

        const createDetailSelects = smallArea => {
            removeOption('detail-option', detail);

            areas.forEach(middleClasses => {
                if(middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"].length === 1) return;
                const smallCode = middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"][0]["smallClassCode"];
                const details = middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"][1]["detailClasses"];
                smallArea === smallCode && details.forEach(detailClasses => {
                    const detailCode = detailClasses["detailClass"]["detailClassCode"];
                    const detailName = detailClasses["detailClass"]["detailClassName"];
                    createOption(detail, detailCode, detailName, 'detail-option', detailEx);
                });
            });
        }

        const isActivationButton = flag => {
            if (flag) {
                searchButton.disabled = flag;
                searchButton.className = 'ml-auto text-white bg-gray-300 border-0 py-2 px-6 focus:outline-none rounded';
            } else {
                searchButton.disabled = flag;
                searchButton.className = 'ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded';
            }
        }

        createOptgroup();
        createOption(small, 0, "未選択", 'small-option-non', smallEx);
        createOption(detail, 0, "未選択", 'detail-option-non', detailEx);

        // selectbox の値がすでに存在した場合の処理
        middle.value && createSmallSelects(middle.value);
        small.value && createDetailSelects(small.value);

        // selectbox middle が変更された際のイベント
        middle.addEventListener('change', e => {
            createSmallSelects(e.target.value);
            removeOption('detail-option', detail);
            small.value === '0' && isActivationButton(true);
        });

        // selectbox small が変更された際のイベント
        small.addEventListener('change', e => {
            createDetailSelects(e.target.value);
            detail.disabled = detail.length <= 1;
            detail.length === 1 ? isActivationButton(false) : isActivationButton(true);
        });

        // selectbox detail が変更された際のイベント
        detail.addEventListener('change', () => {
            isActivationButton(false);
        });
    }
</script>
