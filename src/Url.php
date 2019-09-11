<?php

namespace Gallib\ShortUrl;

use Carbon\Carbon;
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
        'expires_at',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'expires_at',
    ];

    /**
     * Boot the model.
     *
     * @return  void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($url) {
            app()->make('url-parser')->setUrlInfos($url);
        });

        static::updating(function ($url) {
            app()->make('url-parser')->setUrlInfos($url);
        });
    }

    public function couldExpire(): bool
    {
        return $this->expires_at !== null;
    }

    /**
     * Return whether an url has expired.
     *
     * @return bool
     */
    public function hasExpired(): bool
    {
        if (! $this->couldExpire()) {
            return false;
        }

        $expiresAt = new Carbon($this->expires_at);

        return ! $expiresAt->isFuture();
    }
}
