<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class NotInTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->notIn($param);
   }
}
