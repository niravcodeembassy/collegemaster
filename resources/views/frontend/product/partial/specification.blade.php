@if ($faqList->count() > 0)

  @foreach ($faqList as $key => $item)
    <div class="accordion" id="info{{ $key }}">
      <div class="single-faq">
        <div class="card">
          <div class="card-header collapsed" data-toggle="collapse" data-target="#collapsefirst{{ $item->id }}" aria-expanded="false" aria-controls="collapsefirst{{ $item->id }}">
            <h4 class="faq-title">
              {{ $item->title ?? '' }}
            </h4>
          </div>
          <div id="collapsefirst{{ $item->id }}" class="collapse false" aria-labelledby="headingOne" data-parent="#info{{ $key }}" style="">
            <div class="card-body">
              <div class="accordion" id="shippingInfo{{ $key }}">
                @if ($item->children->count() > 0)
                  @foreach ($item->children as $index => $child)
                    <div class="card">
                      <div class="card-header collapsed" data-toggle="collapse" data-target="#collapseOne{{ $child->id }}" aria-expanded="false" aria-controls="collapseOne{{ $child->id }}">
                        <h5 class="mb-0 h5">
                          {{ $child->question ?? '' }}
                        </h5>
                      </div>
                      <div id="collapseOne{{ $child->id }}" class="collapse false" aria-labelledby="headingOne" data-parent="#shippingInfo{{ $key }}" style="">
                        <div class="card-body">
                          {!! $child->answer !!}
                        </div>
                      </div>
                    </div>
                  @endforeach
                @endif
              </div>
            </div>
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
