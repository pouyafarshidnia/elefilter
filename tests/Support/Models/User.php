<?php

namespace Tests\Support\Models;

use EleFilter\Traits\Filterable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use Filterable;

    protected $guarded = [];

    protected ?string $filter_namespace = '';


    public static function banned(): Builder
    {
        return User::where('created_at', '2025');
    }
}
