<div wire:ignore.self class="modal fade" id="createChatGroupModal" tabindex="-1" aria-labelledby="createChatGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createChatGroupModalLabel">New Group</h5>
            <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form> 
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Name</label> 
                    <input type="text" class="form-control" id="title" placeholder="Enter Name" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button wire:click="submit" class="btn btn-primary">Create</button> 
            </div>
        </form> 
      </div>
    </div>
  </div>
