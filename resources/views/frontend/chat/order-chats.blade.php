@foreach ($orderMsg as $item)
@php
                                    $admin = App\Admin::find($item->customer_id);
                                @endphp
    @if ($item->type == 'admin')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div>
                @if($admin != null)
                                                @if($admin->profile_image != null)
                                                    <img width="35px" src='{{asset('storage/'.$admin->profile_image)}}' style="border-radius: 50px;box-shadow:0px 1px #888888"/>    
                                                @else
                                                    <img width="35px" src='https://collagemaster.com/storage/default/default.png' style="border-radius: 50px;box-shadow:0px 1px #888888"/>    
                                                @endif
                                                
                                                @else
                                                <img width="35px" src='https://collagemaster.com/storage/default/default.png' style="border-radius: 50px;box-shadow:0px 1px #888888"/>    
                                                @endif
                <pre class="my-0 chat-replay-message">{{ $item->msg }}</pre>
            </div>
        </li>
    @endif
    @if ($item->type == 'adminImg')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div>
                @php
                    $adminimg = App\Model\OrderChatAttachment::where('chat_id',$item->id)->get();  
                @endphp
                @foreach ($adminimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{asset('storage/dowload.png')}}" alt="" style="width:25px;position: absolute;margin-left: 44px;margin-top: -19px;"></a>
                    <img src="{{asset('storage/'.$img->attachment)}}" alt="" style="width:100px;height:100px;">       
                @endforeach
                <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}" id="{{ $item->id }}">-->
                <!--    <h6 class="my-0 chat-replay-message"><i class="ion-android-download"></i></h6>-->
                <!--</a>-->
            </div>
        </li>
    @endif

    @if ($item->type == 'customer')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div class="text-right" style="width:100%">
                <pre class="my-0 chat-message"> {{ $item->msg }}</pre>
            </div>
        </li>
    @endif
    @if ($item->type == 'custImg')
        <li class="list-group-item d-flex justify-content-between lh-condensed"
            style="border-bottom: 0px;padding:.10rem 1rem!important;padding-top:10px!important">
            <div class="text-right" style="width:100%">
                 @php
                    $custimg = App\Model\OrderChatAttachment::where('chat_id',$item->id)->get();  
                @endphp
                @foreach ($custimg as $img)
                    <a href="{{ route('admin.orders.msg.attachment', ['id' => $img->id]) }}"><img src="{{asset('storage/dowload.png')}}" alt="" style="width:25px;position: absolute;margin-left: 44px;margin-top: -19px;"></a>
                    <img src="{{asset('storage/'.$img->attachment)}}" alt="" style="width:100px;height:100px;">       
                @endforeach
                <!--<a href="{{ route('admin.orders.msg.attachment', ['id' => $item->id]) }}" id="{{ $item->id }}">-->
                <!--    <h6 class="my-0 chat-message"><i class="ion-android-download"></i></h6>-->
                <!--</a>-->
            </div>
        </li>
    @endif
@endforeach
