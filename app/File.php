<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        'fullname', 'name', 'extension', 'folder_id', 'client_id', 'inserted_by',
    ];
}
