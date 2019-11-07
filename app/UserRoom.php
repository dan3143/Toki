<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRoom extends Model
{
    public function isFull(){
        return $this->current_capacity == 0;
    }
}
