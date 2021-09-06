<div wire:ignore.self class="modal fade" id="groupMemberUpdateModal" tabindex="-1" aria-labelledby="grouMemberUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="grouMemberUpdateModalLabel">Update Group Members</h5>
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
                    <hr/>
                    @if(isset($members) && count($members))
                        <h6>Existing Members</h6>
                        <ul>
                        @foreach ($members as $member)
                            <li id="member_{{ $member->id }}">
                                {{ $member->name }}({{ $member->email }})
                                <a class="btn btn-danger btn-sm float-right" wire:click='removeMember("{{ $member->id }}")'>
                                    <i class="fas fa-trash"></i>
                                </a>
                            </li>
                        @endforeach
                        </ul>
                    @endif
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