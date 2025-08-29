<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class AfterTodayTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(): void
   {
      $this->afterToday();
   }
}
