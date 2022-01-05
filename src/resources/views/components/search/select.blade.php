@php
    $areasJson = json_encode($areas);
@endphp
<select name="middle" id="middle" class="mb-2 lg:mb-0 lg:mr-2">
    <optgroup label="都道府県を選択">
        <option value="">
            未選択
        </option>
    @foreach($areas as $area)
        <option value="{{ $area["middleClass"][0]["middleClassCode"] }}">
            {{ $area["middleClass"][0]["middleClassName"] }}
        </option>
    @endforeach
</select>
<select name="small" id="small" class="mb-2 lg:mb-0 lg:mr-2">
</select>

<script>
    const middle = document.getElementById('middle');
    const small = document.getElementById('small');
    middle.addEventListener('change', (e) => {
        const middleArea = e.target.value;
        const areas = <?php echo $areasJson ?>;
        console.log(middleArea)
        areas.forEach(element => {
            const middleCode = element["middleClass"][0]["middleClassCode"];
            const smalls = element["middleClass"][1]["smallClasses"];
            if(middleArea === middleCode){
                const optgroup = document.createElement('optgroup');
                optgroup.label = "地域を選択";
                small.appendChild(optgroup);
                createOption(smalls);
            }
        });
    })
    const createOption = smalls => {
        smalls.forEach(element => {
            const smallCode = element["smallClass"][0]["smallClassCode"];
            const smallName = element["smallClass"][0]["smallClassName"];
            const option = document.createElement('option');
            option.value = smallCode;
            option.innerHTML = smallName;
            small.appendChild(option);
        });
    }
</script>
