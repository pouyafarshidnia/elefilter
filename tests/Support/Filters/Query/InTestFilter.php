<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class InTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(mixed $param): void
   {
      $this->in($param);
   }
}
