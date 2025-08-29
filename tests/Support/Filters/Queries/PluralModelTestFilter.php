<?php

namespace Tests\Support\Filters\Queries;

use EleFilter\Database\ModelFilter;

class PluralModelTestFilter extends ModelFilter
{
   protected string $column = "title";

   public function apply(mixed $param): void
   {
      $this->equal($param);
   }
}
