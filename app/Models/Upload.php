<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;
    
    protected $table='uploads';

    protected $fillable = [
        'file_loc',
        'file_type',
        'file_name',
        'file_size',
        'uploaded_by',
        'note',
        'is_thumbnail',
        'is_default',
        'alt_text'
    ];

    protected $hidden=[
        'uploadable_type',
        'uploadable_id',
        'updated_at',
        'created_at'
    ];

    public function uploadable(){
        return $this->morphTo();
    }

    public function saveFile($file,$type)
    {
        $fullName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);;
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getClientMimeType();
        $newfilename = uniqid().'-'.\Str::slug($fullName).'.'.$extension;
        $done = Storage::disk('public')->put($type.'_'.$newfilename, file_get_contents($file));
        $size = Storage::disk('public')->size($type.'_'.$newfilename);

        $data = [
            'file_loc'=>$type.'_'.$newfilename,
            'file_type'=>$mime,
            'file_name'=>$fullName,
            'file_size'=>$size,
            'url'=>Storage::disk('public')->url($type.'_'.$newfilename)
        ];
        //$file = $task->upload()->create($data);
        return $data;
    }
}
