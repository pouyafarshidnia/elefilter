<?php

namespace Tests\Support\Models;

use EleFilter\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Query extends Model
{
    use HasFactory, Filterable;
}
