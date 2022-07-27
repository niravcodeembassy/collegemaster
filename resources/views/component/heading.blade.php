
<div class="row d-flex mb-2">
    @if (isset($page_title))
        <div class="col">
            
            <div class="page-header-title">
                <h4 class="d-inline-block">
                    @if ($icon)
                        <i class="{{ $icon ?? 'ik ik-menu' }} d-inline-block "></i>    
                    @endif
                    {{ $page_title  }}
                </h4>
            </div>

        </div>
    @endif
    <div class="col">
        <div class="d-flex justify-content-end align-items-center ">
            @if (isset($action) )            
                <a href="{{ $action }}" class="btn btn-secondary btn-sm shadow " {{ isset($attr) ? str_replace('"',' ', $attr ) : '' }}  >
                    <i class="{{ isset($action_icon) ? $action_icon : 'fa fa-plus' }} "></i> {{ $text }}
                </a>
            @endif
            {{ $slot }}
        </div>
        
    </div>
</div>
