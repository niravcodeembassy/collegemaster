@foreach ($chat as $item)
    @if ($item->type == 'customer')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div>
                <h6 class="my-0 chat-replay-message">{{ $item->msg }}</h6>
            </div>
        </li>
    @endif
    @if ($item->type == 'adminImg')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div class="text-right" style="width:100%">
                @php
                    $adminimg = App\Model\OrderChatAttachment::where('chat_id',$item->id)->get();  
                @endphp
                @foreach ($adminimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{asset('storage/dowload.png')}}" alt="" style="width:25px;position: absolute;margin-left: 38px;margin-top: 31px;"></a>
                    <img src="{{asset('storage/'.$img->attachment)}}" alt="" style="width:100px;height:100px;">       
                @endforeach
                <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}" id="{{ $item->id }}">-->
                <!--    <h6 class="my-0 chat-message"><i class="fa fa-download"></i></h6>-->
                <!--</a>-->
            </div>
        </li>
    @endif

    @if ($item->type == 'admin')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div class="text-right" style="width:100%">
                <h6 class="my-0 chat-message"> {{ $item->msg }}</h6>
            </div>
        </li>
    @endif
    @if ($item->type == 'custImg')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div>
               @php
                    $custimg = App\Model\OrderChatAttachment::where('chat_id',$item->id)->get();  
                @endphp
                @foreach ($custimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{asset('storage/dowload.png')}}" alt="" style="width:25px;position: absolute;margin-left: 38px;margin-top: 31px;"></a>
                    <img src="{{asset('storage/'.$img->attachment)}}" alt="" style="width:100px;height:100px;">       
                @endforeach
                <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}" id="{{ $item->id }}">-->
                <!--    <h6 class="my-0 chat-replay-message"><i class="fa fa-download"></i></h6>-->
                <!--</a>-->
            </div>
        </li>
    @endif
@endforeach
