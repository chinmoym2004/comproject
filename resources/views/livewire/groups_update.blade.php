<div wire:ignore.self class="modal fade" id="editgroupModal" tabindex="-1" aria-labelledby="editgroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editgroupModalLabel">Update Group Details</h5>
            <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Title</label> 
                    <input type="text" class="form-control" id="title" placeholder="Enter a title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    <label for="title">Description</label> 
                    <textarea class="form-control" id="description" placeholder="Enter description" wire:model="description"></textarea>
                    @error('description') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button> 
            </div>
        </form> 
      </div>
    </div>
</div>