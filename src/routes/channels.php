<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('me', function ($user) {
    return \Illuminate\Support\Facades\Auth::check();
});


// Broadcast::channel('App.User.{id}', function ($user, $id) {
//     return (int) $user->id === (int) $id;
// });

Broadcast::channel('chat-{chatid}-messages', function ($user, $chatid) {
    info("in chat-{chatid}-messages");
    info($chatid);
    info($user->id);
    return true;
});

Broadcast::channel('room-{chatid}', function ($user, $chatid) {
    return \Illuminate\Support\Facades\Auth::check();
    // if ($user->canJoinRoom($roomId)) {
    //     return ['id' => $user->id, 'name' => $user->name];
    // }
    //return true;
});