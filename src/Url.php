<?php

namespace Gallib\ShortUrl;

use Illuminate\Database\Eloquent\Model;

class Url extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'shorturl_urls';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'url',
        'code',
    ];

    /**
     * Set the code.
     *
     * @param  string  $code
     * @return void
     */
    public function setCodeAttribute($code)
    {
        while (static::whereCode($code)->exists()) {
            $code = \Hasher::generate();
        }

        $this->attributes['code'] = $code;
    }
}
