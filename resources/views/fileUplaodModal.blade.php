<div wire:ignore.self class="modal fade" id="fileUplaodModal" tabindex="-1" aria-labelledby="fileUplaodModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="fileUplaodModalLabel">Members</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
        </div>
        <form wire:submit.prevent="update"> 
            <input type="hidden" wire:model="active_room">
            <div class="modal-body">
                <div class="form-group"> 
                    <label for="title">Title</label> 
                    <input wire:ignore type="text" class="form-control" id="title" placeholder="Enter title" wire:model="title"> 
                    @error('title') <span class="text-danger error">{{ $message }}</span>@enderror
                </div>
    
                <div>
                    <ul>
                    @if($chat_participants)
                        @foreach ($chat_participants as $member)
                            <li>
                                {{ $member->name }}
                            </li>
                        @endforeach
                    @endif
                    </ul>
                </div>
            </div>
    
            <div class="modal-footer">
                <button type="button" wire:click='cancel' class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button> 
            </div>
        </form> 
        </div>
    </div>
    </div>
    