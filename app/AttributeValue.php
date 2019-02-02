<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    public function attribute()
    {
        return $this->morphMany(ProductGroup::class,'attribute_id');
    }
    public function attributeName(){
        return $this->belongsTo(Attribute::class,'attribute_id');
    }

    public function item(){
        return $this->belongsToMany(AttributeValue::class,'product_groups','item_id','attribute_id')->withTimestamps();
    }

}
