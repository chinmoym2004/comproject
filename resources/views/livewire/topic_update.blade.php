<div wire:ignore.self class="modal fade" id="editTopicModal" tabindex="-1" aria-labelledby="editForumModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editForumModalLabel">Update Topic</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="name">Title</label> 
                    <input wire:ignore type="text" class="form-control" id="title" placeholder="Enter title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                    <label for="name">Title</label> 
                    <textarea wire:ignore class="form-control" id="body" placeholder="Enter some details .." wire:model="body"></textarea> 
                    @error('body') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button> 
            </div>
        </form> 
      </div>
    </div>
</div>