<div wire:ignore.self class="modal fade" id="usersearchModal" tabindex="-1" aria-labelledby="usersearchModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="usersearchModalLabel">Add Member in Chat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="search">Type to search</label> 
                    <input wire:ignore type="text" class="form-control" id="search" placeholder="Enter search" wire:model="search">
                </div>
                <div class="width-100" id="selecetd_user">
                    
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
