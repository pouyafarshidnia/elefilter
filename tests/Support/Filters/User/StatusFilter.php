<?php

namespace Tests\Support\Filters\User;

use EleFilter\Database\ModelFilter;

class StatusFilter extends ModelFilter
{
   protected string $column = "email_verified_at";

   public function verified(): void
   {
      $this->notNull();
   }

   public function unverified(): void
   {
      $this->null();
   }


   public function banned(): void
   {
      $this->builder->where('status', -1);
   }


   # Test that filter method will be skipped in macro
   public function filter(): void
   {
      $this->builder->where('status', 0);
   }
}
