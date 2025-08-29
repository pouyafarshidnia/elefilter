<?php

namespace Tests\Support\Models\Order;

use EleFilter\Traits\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Invoice extends Model
{
    use Filterable, HasFactory;

    protected $guarded = [];
    protected $filter_namespace = 'Tests\Support\Filters\Order';
}
