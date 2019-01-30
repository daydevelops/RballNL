<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

	protected $guarded = [];

	protected static function boot() {
		parent::boot();
		static::addGlobalScope('replyCount', function ($builder) {
			$builder->withCount('replies');
		});
	}

	public function replies() {
		return $this->hasMany(ThreadReply::class);
	}
	public function user() {
		return $this->belongsTo(User::class);
	}
	public function category() {
		return $this->belongsTo(Category::class);
	}

	public function addReply($reply) {
		$this->replies()->create($reply);
	}
	public function getPath() {
		return "/forum/".$this->category->slug."/".$this->id;
	}

	public function scopeFilter($query, $filters) {
		return $filters->apply($query);
	}

}
