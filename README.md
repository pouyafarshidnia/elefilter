<p align="center">
<img src="https://elefilter.pouyafarshidnia.com/img/filter.png" style="width:150px" alt="EleFilter">
</p>
<h1 align="center">EleFilter</h1>
<h3 align="center">Easy and Clean Filter Package
For Laravel Applications</h3>
<br>
<br>
<br>

[![Latest Version on Packagist](https://img.shields.io/packagist/v/your-namespace/elefilter.svg?style=flat-square)](https://packagist.org/packages/your-namespace/elefilter)
[![Total Downloads](https://img.shields.io/packagist/dt/your-namespace/elefilter.svg?style=flat-square)](https://packagist.org/packages/your-namespace/elefilter)


**Elefilter** is a Laravel package that helps you easily create and organize **filter classes** for your Eloquent models.  
It provides a simple Artisan command (`make:filter`) and a clean structure for building reusable filters.

👉 Full documentation available at: [here](https://elefilter.pouyafarshidnia.com)


---

## Requirements

- PHP **8.2+**

---

## Installation

Install the package via Composer:

```bash
composer require elefilter/elefilter
```

---

## Make model filterable

Add Filterable Trait to the model

```php
use EleFilter\Traits\Filterable;

class User extends Model
{
    use HasFactory, Filterable;
}
```

## Create a class filter

With command make:filter, you can create a filter class for your model

```bash
php artisan make:filter User/Status --column=email_verified_at
```

## Define query

Inside filter class you can define the query conditions inside methods

```php

namespace App\Filters\User;

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

}

```

## Use filter method 

When you want to get results, you can apply the filters like this:


```php

$verifiedUsers = User::filter([ 'status'  => 'verified' ])->get();

$unverifiedUsers = User::filter([ 'status'  => 'unverified' ])->get();

```

Or use macro methods: 


```php

$verifiedUsers = User::verified()->get();

$unverifiedUsers = User::unverified()->get();

```

## Filters with arguments

For filter which needs argument like search filter, you can use default apply method inside class filters :

```php

namespace App\Filters\User;

use EleFilter\Database\ModelFilter;

class SearchFilter extends ModelFilter
{
   protected string $column = "email";

   public function apply(mixed $param): void
   {
      $this->like($param);
   }
}
```

And call it like this: 

```php

$users = User::filter(['search' => 'test'])->get();

```

Or use macro methods : 
```php

$users = User::search('test')->get();

```

In the front end side in your filter form, assign the class filter names (without suffix Filter) as name attribute for the inputs and values can be method names or the given parameter.An example is like this:

```HTML

<form method="get">

   <label for="asc" >oldest</label>
   <input type="radio" name="sort" id="asc" value="oldest" />

   <label for="desc" >newest</label>
   <input type="radio" name="sort" id="desc" value="newest" />

   <input type="text" name="search" />

   <select name="status">
      <option value="pending">pending</option>
      <option value="approved">approved</option>
      <option value="rejected">rejected</option>
   </select>

</form>

```

For detailed documentaion, more examples, possible conflics, limitation and testing, please refer to website.
