<?php

use Tests\Support\Models\Order\Invoice;
use Tests\Support\Models\Query;
use Tests\Support\Models\Ticket;
use Tests\Support\Models\User;

it('can filter filters/model/class ', function (): void {

    $user = User::filter(['search' => 'test']);

    $expected_sql = 'select * from "users" where "email" like ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('can filter filters/class ', function (): void {

    $user = User::filter(['UserRegister' => [1, 2]]);

    $expected_sql = 'select * from "users" where "created_at" between ? and ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('can filter filters/models/class ', function (): void {

    $user = Ticket::filter(['search' => 'test']);

    $expected_sql = 'select * from "tickets" where "subject" like ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('can filter filters/models/subfolder/class ', function (): void {

    $user = Ticket::filter(['Status' => 'pending']);

    $expected_sql = 'select * from "tickets" where "status" = ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('can filter filters/subfolder/model/class ', function (): void {

    $user = Invoice::filter(['Price' => 'free']);

    $expected_sql = 'select * from "invoices" where "price" = ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('can filter plural models ends with y', function (): void {

    $query = Query::filter(['PluralModelTest' => 'test']);

    $expected_query = 'select * from "queries" where "title" = ?';

    expect($query->toSql())->toBe($expected_query);
});


it('accepts s as search class name ', function (): void {

    $user = User::filter(['s' => 'test']);

    $expected_sql = 'select * from "users" where "email" like ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('accepts q as search class name ', function (): void {

    $user = User::filter(['q' => 'test']);

    $expected_sql = 'select * from "users" where "email" like ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('does not apply any filter if class filter is not valid', function (): void {

    $user = User::filter(['invalidClassName' => 'test']);

    $expected_sql = 'select * from "users"';

    expect($user->toSql())->toBe($expected_sql);
});
