<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Message extends Model
{
    use HasFactory;

    protected $fillable = ['message', 'user_id', 'order_by', 'read', 'clear', 'clear_date', 'read_date'];

    const CLEAR = 1;
    const DONT_CLEAR = 0;

    const READ = 1;
    const DONT_READ = 0;

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

