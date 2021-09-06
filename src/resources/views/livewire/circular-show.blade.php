<div>
    <section class="content">
        <div class="row">
            <div class="col-sm-12 d-flex align-items-stretch flex-column">
                <div class="card bg-light d-flex flex-fill">
                  <div class="card-header text-muted border-bottom-0">
                    Title : {{ $circular->title }}
                  </div>
                  <div class="card-body pt-0">
                    <h5>Details:</h5>
                    <div>
                        <?=$circular->details;?>
                    </div>
                  </div>
                  <div class="card-footer">
                    <div class="text-right">
                        @if($circular->need_confirmation && !$has_ack)
                            Need Your Acknowldegement. Click &nbsp;
                            <a href="#" class="btn btn-sm btn-success" wire:click='acknowldge("{{ encrypt($circular->id) }}")'>
                                <i class="fas fa-check"></i>&nbsp;&nbsp;&nbsp;I Acknowldegement
                            </a>
                        @elseif($circular->need_confirmation && $has_ack)
                            You have acknowledged 
                        @else  
                            Acknowledged not required
                        @endif
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </section>
</div>