<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class GreaterThanTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->greaterThan($param);
   }
}
