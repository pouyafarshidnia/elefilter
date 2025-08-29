<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class LowerOrEqualThanTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->lowerOrEqualThan($param);
   }
}
