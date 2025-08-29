<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class AscTestFilter extends ModelFilter
{
   protected string $column = "created_at";

   public function apply(): void
   {
      $this->asc();
   }
}
