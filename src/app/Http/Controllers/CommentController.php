<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //print_r($request->all());
        $me = $this->currentuser();

        $reference = decrypt($request->reference);
        $reference_id = decrypt($request->reference_id);

        $obj = $reference::find($reference_id);

        if($obj)
        {
            $comment = $obj->comments()->create([
                'comment_text'=>$request->comment_text,
                'comment_by'=>$me->id,
                'parent_id'=>$request->parent_id ?? null,
            ]);

            if($request->hasFile('file'))
            {
                $files = $request->file('file');
                foreach($files as $file)
                {
                    $filename = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $unique_id = uniqid();
                    
                    $uploadfile = new Upload;
                    $filedata = $uploadfile->saveFile($file,$reference);
                    $filedata['uploaded_by']=$me->id;
                    $filedata['is_thumbnail']=0;
                    $filedata['is_default']=0;
                    $filedata['note']='A file was uploaded for '. $reference .' form IP : '.$request->ip();
                    $comment->upload()->create($filedata);

                    $msg = $filedata['file_type'].' type file was uploaded for '.$reference.' by <b>'.$me->name.'</b>';

                    parent::logMe(['type' => 'Comment','type_id'=>$comment->id,'note' => 'comment_file', 'action_details' => $msg,'user_id'=>$me->id],$me);
                }

                $comment->has_file=1;
                $comment->save();
            }

            $view = view('widgets.each_comment',['comment'=>$comment,'record'=>$obj])->render();
            return parent::success(['message'=>'Comment posted','view'=>$view,'hasParent'=>$request->parent_id?1:0]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
