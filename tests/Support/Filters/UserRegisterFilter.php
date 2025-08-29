<?php

namespace Tests\Support\Filters;

use EleFilter\Database\ModelFilter;

class UserRegisterFilter extends ModelFilter
{
   protected string $column = "created_at";

   public function apply(mixed $param): void
   {
      $this->between($param);
   }
}
