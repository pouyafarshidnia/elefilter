<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class GreaterOrLowerThanTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->greaterOrLowerThan($param);
   }
}
