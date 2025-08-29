<?php

namespace Tests\Support\Filters\Query;

use EleFilter\Database\ModelFilter;

class BeforeTodayTestFilter extends ModelFilter
{
   protected string $column = "paid_at";

   public function apply(): void
   {
      $this->beforeToday();
   }
}
