<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class TodayTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(): void
   {
      $this->today();
   }
}
