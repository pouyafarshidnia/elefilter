<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class YearTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(mixed $param): void
   {
      $this->year($param);
   }
}
