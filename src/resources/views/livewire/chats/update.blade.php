<div wire:ignore.self class="modal fade" id="editChatGroupModal" tabindex="-1" aria-labelledby="editChatGroupModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editChatGroupModalLabel">Update Chat Group</h5>
            <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Name</label> 
                    <input type="text" class="form-control" id="title" placeholder="Enter Name" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div> 

                <div class="form-group"> 
                    <label for="exampleFormControlInput2">Members</label> 
                    <div>
                        <a href="#" id='selectallmember' class="pull-right">Select All</a>
                        <select id="chatMembers" class="form-control select2" wire:model="member_ids" multiple="multiple">
                            @foreach ($members as $member)
                            <option value="{{ $member->id }}" @if(in_array($member->id,$member_ids)) selected @endif>{{ $member->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    @error('member_ids') <span class="text-danger error">{{ $message }}</span>@enderror 
                </div> 
            </div>
            <div class="modal-footer">
                <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Create</button> 
            </div>
        </form> 
      </div>
    </div>
</div>