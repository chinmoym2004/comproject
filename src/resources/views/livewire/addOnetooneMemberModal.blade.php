<div wire:ignore.self class="modal fade show" style="display: block;" tabindex="-1" id="onetoonemodalAddUser" aria-labelledby="onetoonemodal" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="onetoonemodal">Add Users</h5>
            <button type="button" wire:click="cancel" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
        </div>
        <form wire:submit.prevent="updateMember"> 
            <input type="hidden" wire:model="selected_id">
            <div class="modal-body">
                @livewire('user-search')

                <div class="modaluserlist">
                    @if($member_ids)
                        <h6>Add New Members</h6>
                        <ul>
                        @foreach ($member_ids as $key=>$text)
                            <li>
                                {{ $text }}
                                <a class="btn btn-danger btn-sm float-right" wire:click='unselectMember("{{ $key }}")'>
                                    <i class="fas fa-times"></i>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endif
                </div> 
            </div>
            <div class="modal-footer">
                <button wire:click="cancel" type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button> 
            </div>
        </form> 
      </div>
    </div>
</div>