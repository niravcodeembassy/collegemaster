{{--<div class="text-center">
    <i class="ik ik-more-horizontal- f-22 dropdown-toggle" data-toggle="dropdown"
       aria-haspopup="true" aria-expanded="false"></i>
    <div class="dropdown-menu dropdown-menu-right">

        @if(isset($edit))
            <a class="dropdown-item f-14" href="{{ $edit ?? 'javascrip:void(0)' }}">
                <i class="ik ik-edit-1 "></i> &nbsp; <span class="">Edit</span>
            </a>
        @endif

        @if (isset($edit_modal))
            <a class="dropdown-item f-14 call-model"
               data-target-modal="{{ $edit_modal->get('target') }}"
               data-id={{ $edit_modal->get('id') }}
                   data-url="{{ $edit_modal->get('action' , 'javaqscrip:void(0)') }}"
               href="{{ $edit_modal->get('action' , 'javaqscrip:void(0)') }}">
                <i class="ik ik-edit-1 "></i> &nbsp; <span class="">Edit</span>
            </a>
        @endif

        @if(isset($view))
            <a class="dropdown-item f-14 call-model"
               data-target-modal="{{ $view->get('target') }}"
               data-id={{ $view->get('id') }}
                   data-url="{{ $view->get('action' , 'javaqscrip:void(0)') }}"
               href="{{ $view->get('action' , 'javaqscrip:void(0)') }}">
                <i class="ik ik-eye "></i> &nbsp; <span class="">View</span>
            </a>
        @endif

        @if(isset($view_model))
            <a class="dropdown-item f-14" href="{{ $view_model ?? 'javascrip:void(0)' }}">
                <i class="ik ik-eye "></i> &nbsp; <span class="">View</span>
            </a>
        @endif


        @if(isset($list_item))

            @foreach ($list_item as $item)
                <a class="dropdown-item f-14 {{ $modal ?? '' }}"
                   @if($item->get('target' ,null))
                   data-target-modal="{{ $item->get('target') }}"
                   @endif
                   data-id={{ $item->get('id') }}
                       data-url="{{ $item->get('action' , 'javaqscrip:void(0)') }}"
                   href="{{ $item->get('action' , 'javaqscrip:void(0)') }}">
                    <i class="ik {{ $item->get('icon') }} "></i> &nbsp; <span class="">{{ $item->get('action_name') }}</span>
                </a>

            @endforeach

        @endif



        @if (isset($delete))
            <a class="dropdown-item f-14 delete-confirm" data-id={{ $delete->get('id') }}  href="{{ $delete->get('action' , 'javaqscrip:void(0)') }}">
                <i class="ik ik-trash-2 "></i> &nbsp; <span class="">Delete</span>
            </a>
        @endif

    </div>
</div>--}}

@if ($list_item)
    @php
        //$user = request()->user()->hasRole('admin' ,'project-manager');
        $user = true;
        $filtered = collect([]);
        //$filtered = collect([]) ;
        //if(!$user) {
        //    $filtered = collect(collect($list_item)->toArray())->filter(function ($value, $key) {
        //        return $value['permission'] == true;
        //    });
        //}
    @endphp
    <div class="text-center">
        @if ($filtered->count() > 0 || $user)
            <span class="dropdown">
            <a href="javascript:void(0)" class="" style="font-size: 22px;" data-toggle="dropdown" aria-expanded="false">
                <i class='fas fa-ellipsis-h'></i>
            </a>
            @if(isset($list_item))
                <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end">
                    @foreach ($list_item as $item)
                            @if ($item->get('permission') != false || $user)
                                <a class="dropdown-item {{ $item->get('target',null) ? 'call-model' : '' }} {{ $item->get('class',null) }}"
                                    @if($item->get('target' ,null))
                                        data-target-modal="{{ $item->get('target') }}"
                                    @endif
                                        data-id="{{ $item->get('id',null) }}"
                                        data-url="{{ $item->get('action' , 'javaqscrip:void(0)') }}"
                                        href="{{ $item->get('action' , 'javaqscrip:void(0)') }}"
                                        @if($item->get('attrs' ,null))
                                            @foreach ($item->get('attrs') as $key => $attr)
                                                {{$key}}="{{$attr}}"
                                            @endforeach
                                        @endif

                                    ><i class="{{ $item->get('icon') }}"></i>&nbsp;&nbsp;{{$item->get('text')}}
                                </a>
                            @endif
                        @endforeach
                </div>
            @endif
        </span>
        @endif
    </div>
@endif
