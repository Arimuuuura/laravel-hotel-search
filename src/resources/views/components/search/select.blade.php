@php
    $areasJson = json_encode($areas);
    $small = !is_null(\Request::get("small")) ? \Request::get("small") : false;
@endphp
<select name="middle" id="middle" class="mb-2 lg:mb-0 lg:mr-2">
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
<select name="small" id="small" class="mb-2 lg:mb-0 lg:mr-2"></select>
<select name="detail" id="detail" class="mb-2 lg:mb-0 lg:mr-2"></select>

<script>
    'use strict';
    {
        const middle = document.getElementById('middle');
        const small = document.getElementById('small');
        const detail = document.getElementById('detail');
        const smallEx = "<?= $small ?>";

        // const createOptions = (areas, area, className) => {
        //     areas.forEach(element => {
        //         const smallCode = element["smallClass"][0]["smallClassCode"];
        //         const smallName = element["smallClass"][0]["smallClassName"];
        //         createOption(area, smallCode, smallName, className);
        //     });
        // };

        const createOption = (area, code, name, className) => {
            const option = document.createElement('option');
            option.value = code;
            option.innerHTML = name;
            option.classList.add(className);
            optionSelected(option, smallEx, code);
            area.appendChild(option);
        };

        const optionSelected = (option, val, code) => option.selected = val === code && true;

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

        const createSmallSelects = value => {
            const middleArea = value;
            const areas = <?= $areasJson ?>;
            removeOption('small-option', small);

            areas.forEach(element => {
                const middleCode = element["middleClass"][0]["middleClassCode"];
                const smalls = element["middleClass"][1]["smallClasses"];
                if(middleArea === middleCode){
                    smalls.forEach(element => {
                        const smallCode = element["smallClass"][0]["smallClassCode"];
                        const smallName = element["smallClass"][0]["smallClassName"];
                        createOption(small, smallCode, smallName, 'small-option');
                    });
                }
            });
        }

        createOptgroup();
        createOption(small, 0, "未選択");
        createOption(detail, 0, "未選択");

        // selectbox の値がすでに存在した場合の処理
        middle.value && createSmallSelects(middle.value);

        // selectbox middle が変更された際のイベント
        middle.addEventListener('change', (e) => {
            createSmallSelects(e.target.value);
        });

        // selectbox small が変更された際のイベント
        small.addEventListener('change', (e) => {
            const smallArea = e.target.value;
            const areas = <?= $areasJson ?>;
            removeOption('detail-option', detail);

            areas.forEach(element => {
                if(element["middleClass"][1]["smallClasses"][0]["smallClass"].length > 1) {
                    const smallCode = element["middleClass"][1]["smallClasses"][0]["smallClass"][0]["smallClassCode"];
                    if(smallArea === smallCode){
                        const details = element["middleClass"][1]["smallClasses"][0]["smallClass"][1]["detailClasses"];
                        details.forEach(e => {
                            const detailCode = e["detailClass"]["detailClassCode"];
                            const detailName = e["detailClass"]["detailClassName"];
                            createOption(detail, detailCode, detailName, 'detail-option');
                        });
                    }
                }
            });
        });
    }
</script>
