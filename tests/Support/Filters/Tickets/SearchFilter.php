<?php

namespace Tests\Support\Filters\Tickets;

use EleFilter\Database\ModelFilter;

class SearchFilter extends ModelFilter
{
   protected string $column = "subject";

   public function apply(mixed $param): void
   {
      $this->like($param);
   }
}
