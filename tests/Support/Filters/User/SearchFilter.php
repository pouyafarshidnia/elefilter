<?php

namespace Tests\Support\Filters\User;

use EleFilter\Database\ModelFilter;

class SearchFilter extends ModelFilter
{
   protected string $column = "email";

   public function apply(mixed $param): void
   {
      $this->like($param);
   }
}
