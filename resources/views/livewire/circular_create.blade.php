<div wire:ignore.self class="modal fade" id="createcircularModal" tabindex="-1" aria-labelledby="createcircularModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createcircularModalLabel">New Circular</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Title</label> 
                    <input wire:ignore type="text" class="form-control" id="title" placeholder="Enter title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    <label for="title">Details</label> 
                    <textarea wire:ignore class="form-control" id="details" placeholder="Enter details" wire:model="details"></textarea>
                    @error('details') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    
                    <label for="need_confirmation">
                        <input type="checkbox" id="need_confirmation" wire:model="need_confirmation" checked/>
                        Need Acknowledgement?
                    </label> 
                    @error('need_confirmation') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button> 
            </div>
        </form> 
      </div>
    </div>
  </div>
