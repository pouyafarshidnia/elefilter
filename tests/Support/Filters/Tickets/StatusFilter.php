<?php

namespace Tests\Support\Filters\Tickets;

use EleFilter\Database\ModelFilter;

class StatusFilter extends ModelFilter
{
   protected string $column = "status";


   public  function pending(): void
   {
      $this->equal(0);
   }


   public  function open(): void
   {
      $this->equal(1);
   }


   public  function closed(): void
   {
      $this->equal(-1);
   }
}
