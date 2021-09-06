<div wire:ignore class="modal fade" id="createChatGroupModal" tabindex="-1" aria-labelledby="createChatGroupModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createChatGroupModalLabel">New Group</h5>
            <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="submit"> 
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Name</label> 
                    <input wire:ignore.self type="text" class="form-control" id="title" placeholder="Enter Name" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                  <label for="group_id">Select Group</label> 
                  <select class="form-control" id="group_id" wire:model="group_id">
                    <option value="">Select a group</option>
                    @if($groups)
                      @foreach ($groups as $group)
                          <option value="{{ $group->id }}">{{ $group->title }}</option>
                      @endforeach
                    @endif
                  </select>
                  <p class="text-muted text-sm">Members from the group will see the group in their chat room.</p>
                  @error('group_id') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

                <div class="form-group"> 
                  <label for="is_public">Is Public?</label> 
                  <select class="form-control" id="is_public" wire:model="is_public">
                      <option value="0">No</option>
                      <option value="1">Yes</option>
                  </select>
                  <p class="text-muted text-sm">If 'yes', everyone will see the group in their chat room.</p>
                  @error('is_public') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button class="btn btn-primary" type="submit">Create</button> 
            </div>
        </form> 
      </div>
    </div>
  </div>
