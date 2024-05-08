<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // fillable => It takes care of defining which fields are to be considered when the user will
    // insert or update data. Only the fields marked as fillable are used in the mass assignment.
    // This is done to avoid mass(...) assignment data attacks when the user sends data from the HTTP request.
    protected $fillable = ['title', 'description', 'long_description'];
    // guarded => properties that cannot be mass assignable, allowing all others through. 
    protected $guarded = []; // the opposite of fillable 

    public function toggleComplete()
    {
        // change task state
        $this->completed = !$this->completed;
        $this->save();
    }

}
