<div class="panel panel-content">

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>
            <strong>Sorry!</strong> invalid input.<br><br>
            <ul style="list-style-type:none;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('message')) 

        <div class="alert alert-success" style="margin-top:30px;">x 

          {{ session('message') }} 

        </div> 

    @endif

    @include('livewire.chats.update')
    @include('livewire.chats.create')
    
  
    <table class="table table-bordered mt-5"> 
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Group Name</th>
            <th scope="col">Members</th>
            <th scope="col">Status</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
            @foreach($data as $chat)
        <tr>
            <th scope="row">{{$chat->id}}</th>
            <td>{{$chat->title}}</td>
            <td>{{$chat->members?$chat->members->count():0}}</td>
            <td>{{$chat->status}}</td>
            <td>
                <button data-toggle="modal" data-target="#updateModal" wire:click="edit('{{encrypt($chat->id)}}')" class="btn btn-xs btn-warning">Edit</button>
                    <button wire:click="destroy('{{encrypt($chat->id)}}')" class="btn btn-xs btn-danger">Del</button>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div> 

