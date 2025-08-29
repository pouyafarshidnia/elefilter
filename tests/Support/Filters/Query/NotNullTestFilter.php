<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class NotNullTestFilter extends ModelFilter
{
   protected string $column = "amount";

   public function apply(): void
   {
      $this->notNull();
   }
}
