<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class TimeTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(mixed $param): void
   {
      $this->time($param);
   }
}
