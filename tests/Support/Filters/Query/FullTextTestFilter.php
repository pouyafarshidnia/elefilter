<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class FullTextTestFilter extends ModelFilter
{
   protected string $column = "";

   public function apply(mixed $param): void
   {
      $this->fullText($param);
   }
}
