<div wire:ignore.self class="modal fade" id="createForumModal" tabindex="-1" aria-labelledby="createForumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createForumModalLabel">New Forum</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="name">Name</label> 
                    <input wire:ignore type="text" class="form-control" id="name" placeholder="Enter Name" wire:model="name"> 
                    @error('name') <span class="text-danger error">{{ $message }}</span>@enderror
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
