<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use VanOns\Laraberg\Models\Gutenbergable;

/**
 * @property string title
 */
class Lesson extends Model
{
    use Gutenbergable;

    public $lb_content;

    protected  $fillable = ['title', 'content', 'course_id', 'status'];

    public function course() : BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function content()
    {
        return $this->larabergContent();
    }

    public function messages()
    {
        return $this->morphMany('App\Entities\Message', 'messageable')->with('user');
    }

}
