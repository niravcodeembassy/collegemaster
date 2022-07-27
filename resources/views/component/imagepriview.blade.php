@php
    $image = $priview ?? asset('storage/default/default.png') ;   
@endphp
<div class="form-group" x-data="uploadImage()" x-init="init('{{ $image }}')">
    <label for="{{ $id ?? $name }}" class="text-left">{{ $label }} <span class="text-danger">*</span> </label>
    <div class="position-relative">

        <img id="image" 
            class="rounded w-100" 
            style="height: {{ $height }}; background-color: #e2e8f0; object-fit: contain;"
            :src="preview">
        
        <template x-if="remove == true">
            <span style="top: -5px;right: -5px;cursor: pointer; z-index: 1;" @click="clearPreview('{{ $id ?? $name }}')"
                class="position-absolute d-flex">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1"
                    x="0px" y="0px" viewBox="0 0 455.111 455.111" style="enable-background:new 0 0 455.111 455.111;"
                    xml:space="preserve" width="15px" height="15px" class="">
                    <g>
                        <circle style="fill:#1273EB" cx="227.556" cy="227.556" r="227.556" data-original="#E24C4B" class=""
                            data-old_color="#E24C4B" />
                        <path style="fill:#0F70E7"
                            d="M455.111,227.556c0,125.156-102.4,227.556-227.556,227.556c-72.533,0-136.533-32.711-177.778-85.333  c38.4,31.289,88.178,49.778,142.222,49.778c125.156,0,227.556-102.4,227.556-227.556c0-54.044-18.489-103.822-49.778-142.222  C422.4,91.022,455.111,155.022,455.111,227.556z"
                            data-original="#D1403F" class="active-path" data-old_color="#D1403F" />
                        <path style="fill:#FFFFFF"
                            d="M331.378,331.378c-8.533,8.533-22.756,8.533-31.289,0l-72.533-72.533l-72.533,72.533  c-8.533,8.533-22.756,8.533-31.289,0c-8.533-8.533-8.533-22.756,0-31.289l72.533-72.533l-72.533-72.533  c-8.533-8.533-8.533-22.756,0-31.289c8.533-8.533,22.756-8.533,31.289,0l72.533,72.533l72.533-72.533  c8.533-8.533,22.756-8.533,31.289,0c8.533,8.533,8.533,22.756,0,31.289l-72.533,72.533l72.533,72.533  C339.911,308.622,339.911,322.844,331.378,331.378z"
                            data-original="#FFFFFF" class="" data-old_color="#FFFFFF" />
                    </g>
                </svg>
            </span>
        </template>

        <div style="top: 0; bottom: 0; right: 0; left: 0; "
            class="shadow-sm position-absolute p-2  d-flex justify-content-center align-items-center ">
            <span @click="$refs.{{ $id ?? $name }}.click()" style="background-color: rgba(255, 255, 255, 0.65)"
                class="btn btn-default   btn-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-camera" width="24" height="24"
                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                    stroke-linejoin="round">
                    <rect x="0" y="0" width="12" height="12" stroke="none"></rect>
                    <path
                        d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2">
                    </path>
                    <circle cx="12" cy="13" r="3"></circle>
                </svg>
            </span>
        </div>

    </div>

    <input type="file" name="{{$name}}" multiple x-ref="{{ $id ?? $name }}" 
        name="{{$name}}" 
        id="{{ $id ?? $name }}"  required  
        class="d-none {{ $class??'' }}"
        @change="updatePreview('{{ $id ?? $name }}')">
        
</div>
