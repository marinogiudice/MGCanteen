<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The class specifies the properties for the 
 * Table Model Object
 * 
 * @author Marino Giudice
 */
class Table extends Model
{
    //disables the Ids as primary key
    public $incrementing = 'false';
    //specifies table number as primary key
    protected $primaryKey = 'table_number';
    //specifies primary key type
    protected $keyType = 'integer';
    //fillables property
    protected $fillable = ['table_number'];
}