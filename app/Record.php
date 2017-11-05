<?php
namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;

class Record extends Model {
    protected $table = 'records';
    protected $fillable = ['record'];

}