<?php

namespace App\Models;
use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    use DefaultDatetimeFormat;
    protected $casts = [

        'video'=>'json',
    ];
    public function setVideoAttribute($value){

        $newVideo = [];
        foreach($value as $k=>$v){
                $valueVideo = [];
                if(!empty($v['old_url'])){
                        $valueVideo['url'] = $v['old_url'];  
                }else{
                    $valueVideo['url'] =$v['url'];
                }

                if(!empty($v['old_thumbnail'])){
                    $valueVideo['thumbnail'] = $v['old_thumbnail'];  
                }else{
                    $valueVideo['thumbnail'] =$v['thumbnail'];
                }
                $valueVideo['name'] =$v['name'];
                array_push($newVideo,$valueVideo);
        }
        //json_encode makes it json for the database
        //array_values get the values of the php associative array
        $this->attributes['video'] = json_encode(array_values($newVideo));
    }
    public function getVideoAttribute($value){
        // convert to assciative array
        // "key" => "value"
        $result = json_decode($value, true);
        if(!empty($result)){
            foreach($result as $key => $value){
                $result[$key]['url'] = env('APP_URL')."uploads/".$value['url'];
                $result[$key]['thumbnail'] = env('APP_URL')."uploads/".$value['thumbnail'];
        }
    }
    return $result;
    }   
    public function getThumbnailAttribute($value){
        return env('APP_URL')."uploads/".$value;
    }
}
