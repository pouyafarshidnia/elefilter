<?php

namespace Tests\Support\Models;

use EleFilter\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use Filterable, HasFactory;

    protected $guarded = [];
}
