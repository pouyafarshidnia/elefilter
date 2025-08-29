<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class DayTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(mixed $param): void
   {
      $this->day($param);
   }
}
