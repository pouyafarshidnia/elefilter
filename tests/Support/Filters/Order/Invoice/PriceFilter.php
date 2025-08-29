<?php

namespace Tests\Support\Filters\Order\Invoice;

use EleFilter\Database\ModelFilter;

class PriceFilter extends ModelFilter
{
   protected string $column = "price";


   public function free(): void
   {
      $this->equal(0);
   }
}
