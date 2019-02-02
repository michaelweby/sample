<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function products(){
        return $this->belongsToMany(Product::class);
    }

    // check if name of tag is sorted
    // if not sort it and return it back to use
    public function sorted($name){
        if($tag = Tag::where('name',$name)->first()){
            return $tag;
        }
        $tag = new Tag;
        $tag->name =$name;
        $tag->save();
        return$tag;

    }
}
