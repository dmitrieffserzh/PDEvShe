<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    use HasFactory;
    protected $fillable = [
        'content_id',
        'title',
        'description',
    ];

    public function page(){
        return $this->morphTo();
    }

    public function post(){
        return $this->morphTo();
    }

    public function profile(){
        return $this->morphTo();
    }


	public function station(){
		return $this->morphTo();
	}
}
