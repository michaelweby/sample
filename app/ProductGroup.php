<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductGroup extends Model
{
    public function attributes(){
        return $this->belongsTo(Attribute::class);
    }
}
