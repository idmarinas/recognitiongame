<?php

namespace RecognitionGame\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    protected $table = 'topic';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
