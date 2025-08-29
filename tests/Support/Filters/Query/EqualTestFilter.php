<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class EqualTestFilter extends ModelFilter
{
   protected string $column = "title";

   public function apply(mixed $param): void
   {
      $this->equal($param);
   }
}
