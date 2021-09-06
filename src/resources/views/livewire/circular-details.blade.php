<div>
    <section class="content">
        <div class="row">
            <div class="col-sm-8 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header border-bottom-0">
                    Title : {{ $circular->title }}
                  </div>
                  <div class="card-body pt-0">
                    <p>Need Acknowldegement:&nbsp;&nbsp;<span class="badge badge-success">{{ $circular->need_confirmation?'Yes':'No' }}</span></p>

                    <h5>Details:</h5>
                    <div>
                        <?=$circular->details;?>
                    </div>
                  </div>
                  <div class="card-footer text-right">
                      <em> Last update : {{ date('Y-m-d H:i:s',strtotime($circular->updated_at))}}</em>
                  </div>
                </div>
            </div>
            <div class="col-sm-4 d-flex align-items-stretch flex-column">
              <div class="card bg-light d-flex flex-fill">
                <div class="card-header border-bottom-0">
                  Acknowldegement Response
                </div>
                <div class="card-body pt-0">
                  
                      @if($circular->members->count())
                      <ul>
                        @foreach ($circular->members as $member)
                            <li>{{ $member->name }} &nbsp; <i class="fa fa-{{ $member->pivot->has_confirmed?'check text-success':'exclamation-circle text-red' }}"></i></li>
                        @endforeach
                      </ul>
                      @else 
                        <p class="text-muted">No Result</p>
                      @endif
                  
                </div>
            </div>
        </div>
    </section>
</div>