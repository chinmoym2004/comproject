<?php

namespace App\Http\Controllers;

use App\Models\Forum;
use App\Models\Topic;

use Illuminate\Http\Request;

class ForumController extends Controller
{
    //
    public function index()
    {
        return view('forum');
    }

    public function show($slug)
    {
        $forum = Forum::where('slug',$slug)->first();
        return view('forum-topics',['forum'=>$forum]);
    }

    public function topics($slug,$slug2)
    {
        $topic = Topic::where('slug',$slug2)->first();
        return view('forum_topic_details',['topic'=>$topic]);
    }
}
