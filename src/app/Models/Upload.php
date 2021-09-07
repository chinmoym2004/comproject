<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Storage;

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
        $fullName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = strtolower($file->getClientOriginalExtension());
        $mime = $file->getClientMimeType();

        $newfilename = uniqid().'-'.\Str::slug($fullName).'.'.$extension;

        //$done = Storage::disk('public')->put($type.'_'.$newfilename, file_get_contents($file));
        

        $file->storePubliclyAs('public', $newfilename);
        $size = Storage::disk('public')->size($newfilename);

        return [
            'file_loc'=>$newfilename,
            'file_type'=>$mime,
            'file_name'=>$fullName.'.'.$extension,
            'file_size'=>$size,
            'note'=>'chat file upload',
            'url'=>Storage::disk('public')->url($newfilename)
        ];
    }
}
