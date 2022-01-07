@php
    $areasJson = json_encode($areas);
    $small = \Request::get("small") ?? false;
    $detail = \Request::get("detail") ?? false;
@endphp
<div class="ml-6 items-center">
    <span class="mr-3 text-xs text-gray-500">都道府県を選択</span>
    <div class="relative">
        <select name="middle" id="middle" class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
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
        <select name="small" id="small" class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
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
        <select name="detail" id="detail" class="text-gray-700 rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
        </select>
        <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
              <path d="M6 9l6 6 6-6"></path>
            </svg>
        </span>
    </div>
</div>


<script>
    'use strict';
    {
        const middle = document.getElementById('middle');
        const small = document.getElementById('small');
        const detail = document.getElementById('detail');
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

        const createSmallSelects = middleArea => {
            removeOption('small-option', small);

            areas.forEach(middleClasses => {
                const middleCode = middleClasses["middleClass"][0]["middleClassCode"];
                const smalls = middleClasses["middleClass"][1]["smallClasses"];
                middleArea === middleCode && smalls.forEach(smallClasses => {
                    const smallCode = smallClasses["smallClass"][0]["smallClassCode"];
                    const smallName = smallClasses["smallClass"][0]["smallClassName"];
                    createOption(small, smallCode, smallName, 'small-option', smallEx);
                });
            });
        }

        const createDetailSelects = smallArea => {
            removeOption('detail-option', detail);

            areas.forEach(middleClasses => {
                if(middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"].length > 1) {
                    const smallCode = middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"][0]["smallClassCode"];
                    const details = middleClasses["middleClass"][1]["smallClasses"][0]["smallClass"][1]["detailClasses"];
                    smallArea === smallCode && details.forEach(detailClasses => {
                        const detailCode = detailClasses["detailClass"]["detailClassCode"];
                        const detailName = detailClasses["detailClass"]["detailClassName"];
                        createOption(detail, detailCode, detailName, 'detail-option', detailEx);
                    });
                }
            });
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
        });

        // selectbox small が変更された際のイベント
        small.addEventListener('change', e => {
            createDetailSelects(e.target.value);
        });
    }
</script>
