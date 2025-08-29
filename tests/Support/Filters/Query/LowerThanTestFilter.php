<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class LowerThanTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->lowerThan($param);
   }
}
