<div wire:ignore class="modal fade" id="viewCircularModal" tabindex="-1" aria-labelledby="viewCircularModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog model-md">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="viewCircularModalLabel">View Circular</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                <div class="form-group" wire:ignore> 
                    <label for="title">Title</label> 
                    <p>{{ $this->title }}</p>
                </div>

                <div class="form-group"> 
                    <label for="title">Details</label> 
                    <?=$this->details?>
                </div>

                <div class="form-group"> 
                    @if($this->need_confirmation && !$this->accepted)
                        Need Your Acknowldegement. Click &nbsp;
                        <a href="#" class="btn btn-sm btn-success" wire:click='acknowldge()'>
                            <i class="fas fa-check"></i>&nbsp;&nbsp;&nbsp;I Acknowldegement
                        </a>
                    @elseif($this->need_confirmation && $this->accepted)
                        You have acknowledged 
                    @else  
                        Acknowledged not required
                    @endif
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </form> 
      </div>
    </div>
</div>