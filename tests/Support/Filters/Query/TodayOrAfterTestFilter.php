<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class TodayOrAfterTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(): void
   {
      $this->todayOrAfter();
   }
}
