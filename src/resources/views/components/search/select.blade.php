@php
    $areasJson = json_encode($areas);
    $small = !is_null(\Request::get("small")) ? \Request::get("small") : false;
@endphp
<select name="middle" id="middle" class="mb-2 lg:mb-0 lg:mr-2">
    <optgroup label="都道府県を選択">
        <option value="">
            未選択
        </option>
    @foreach($areas as $area)
        <option value="{{ $area["middleClass"][0]["middleClassCode"] }}" @if(\Request::get("middle") === $area["middleClass"][0]["middleClassCode"]) selected @endif>
            {{ $area["middleClass"][0]["middleClassName"] }}
        </option>
    @endforeach
</select>
<select name="small" id="small" class="mb-2 lg:mb-0 lg:mr-2"></select>

<script>
    'use strict';
    {
        const middle = document.getElementById('middle');
        const small = document.getElementById('small');
        const smallEx = "<?= $small ?>";

        const createOptions = smalls => {
            smalls.forEach(element => {
                const smallCode = element["smallClass"][0]["smallClassCode"];
                const smallName = element["smallClass"][0]["smallClassName"];
                createOption(smallCode, smallName);
            });
        };

        const createOption = (smallCode, smallName) => {
            const option = document.createElement('option');
            option.value = smallCode;
            option.innerHTML = smallName;
            option.classList.add('option');
            option.selected = smallEx === smallCode && true;
            small.appendChild(option);
        };

        const createOptgroup = () => {
            const optgroup = document.createElement('optgroup');
            optgroup.label = "地域を選択";
            small.appendChild(optgroup);
        };

        const removeOption = () => {
            const option = document.getElementsByClassName('option');
            if(option.length) {
                Array.from(option).forEach(node => small.removeChild(node));
            }
        };

        const createSmallSelects = value => {
            const middleArea = value;
            const areas = <?= $areasJson ?>;
            removeOption(small);

            areas.forEach(element => {
                const middleCode = element["middleClass"][0]["middleClassCode"];
                const smalls = element["middleClass"][1]["smallClasses"];
                if(middleArea === middleCode){
                    createOptions(smalls);
                }
            });
        }

        createOptgroup();
        createOption(0, "未選択");

        // selectbox の値がすでに存在した場合の処理
        middle.value && createSmallSelects(middle.value);

        // selectbox が変更された際のイベント
        middle.addEventListener('change', (e) => {
            createSmallSelects(e.target.value);
        });
    }
</script>
