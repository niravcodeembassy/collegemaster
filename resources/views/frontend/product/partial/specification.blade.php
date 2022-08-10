@if ($faqList->count() > 0)

  @foreach ($faqList as $key => $item)
    <div class="accordion" id="info{{ $key }}">
      <div class="single-faq">
        <div class="card">
          <div class="card-header pb-3 collapsed" data-toggle="collapse" data-target="#collapsefirst{{ $item->id }}" aria-expanded="false" aria-controls="collapsefirst{{ $item->id }}">
            <span class="faq-title"> {{ $item->title ?? '' }}</span>
          </div>
          <hr />
          <div id="collapsefirst{{ $item->id }}" class="collapse false" aria-labelledby="headingOne" data-parent="#info{{ $key }}" style="">
            <div class="card-body">
              <div class="accordion" id="shippingInfo{{ $key }}">
                @if ($item->children->count() > 0)
                  @foreach ($item->children as $index => $child)
                    <div class="card">
                      <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOne{{ $child->id }}" aria-expanded="false" aria-controls="collapseOne{{ $child->id }}">
                        <span class="mb-0 h5"> {{ $child->question ?? '' }}</span>
                      </div>
                      <div id="collapseOne{{ $child->id }}" class="collapse false" aria-labelledby="headingOne" data-parent="#shippingInfo{{ $key }}" style="">
                        <div class="card-body" style="padding: 0.25rem 1.25rem!important;">
                          {!! $child->answer !!}
                          @if (!$loop->last)
                            <hr />
                          @endif
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
            <hr />
          </div>
        </div>
      </div>
    </div>
  @endforeach
@else
  <div class="text-center">
    <h4 class="text-muted">No Specification found</h4>
  </div>
@endif
