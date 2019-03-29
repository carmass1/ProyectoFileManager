<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
	protected $fillable = [
        'name', 'parent_id', 'tree_id', 'path', 'last_update'
	];
	
}
