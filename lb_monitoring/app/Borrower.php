<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Borrower extends Model
{
    protected $table = 'account_information';
    protected $fillable = ['id_number','fullname','type','printing_token']; 
}
