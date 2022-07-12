<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Station extends Model {
	use Filterable;
	use HasFactory;
	use AsSource;
	protected $fillable = [
		'slug',
		'name',
		'title',
		'content'
	];

    public $timestamps = false;

	protected $allowedFilters = [ 'id', 'title' ];

    // RELATIONS
    public function profiles() {
        return $this->belongsToMany( Profile::class, 'profile_station' );
    }

	public function meta() {
		return $this->morphOne(Meta::class, 'metable');
	}
}
