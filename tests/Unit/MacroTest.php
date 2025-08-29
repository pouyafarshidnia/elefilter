<?php

use Tests\Support\Models\Order\Invoice;
use Tests\Support\Models\Ticket;
use Tests\Support\Models\User;

it('load verified method for user properly', function (): void {

    $user = User::verified();

    $expected_sql = 'select * from "users" where "email_verified_at" is not null';

    expect($user->toSql())->toBe($expected_sql);
});


it('load unverified method for user properly', function (): void {

    $user = User::unverified();

    $expected_sql = 'select * from "users" where "email_verified_at" is null';

    expect($user->toSql())->toBe($expected_sql);
});


it('load search method for user properly', function (): void {

    $user = User::search('test');

    $expected_sql = 'select * from "users" where "email" like ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('load user register method for user properly', function (): void {

    $user = User::userRegister([1, 2]);

    $expected_sql = 'select * from "users" where "created_at" between ? and ?';

    expect($user->toSql())->toBe($expected_sql);
});


it('load search method for ticket properly', function (): void {

    $ticket = Ticket::search('test');

    $expected_sql = 'select * from "tickets" where "subject" like ?';

    expect($ticket->toSql())->toBe($expected_sql);
});


it('load pending status method for ticket properly', function (): void {

    $ticket = Ticket::pending();

    $expected_sql = 'select * from "tickets" where "status" = ?';

    expect($ticket->toSql())->toBe($expected_sql)
        ->and($ticket->getBindings())->toBe([0]);
});


it('load open status method for ticket properly', function (): void {

    $ticket = Ticket::open();

    $expected_sql = 'select * from "tickets" where "status" = ?';

    expect($ticket->toSql())->toBe($expected_sql)
        ->and($ticket->getBindings())->toBe([1]);
});


it('load closed status method for ticket properly', function (): void {

    $ticket = Ticket::closed();

    $expected_sql = 'select * from "tickets" where "status" = ?';

    expect($ticket->toSql())->toBe($expected_sql)
        ->and($ticket->getBindings())->toBe([-1]);
});


it('load free status method for invoice properly', function (): void {

    $invoice = Invoice::free();

    $expected_sql = 'select * from "invoices" where "price" = ?';

    expect($invoice->toSql())->toBe($expected_sql)
        ->and($invoice->getBindings())->toBe([0]);
});


it('can be appliable before other conditions', function (): void {

    $user = User::verified()->where('email', 'like', '%test%');

    $expected_sql = 'select * from "users" where "email" like ? and "email_verified_at" is not null';

    expect($user->toSql())->not()->toBe($expected_sql);
});


it('can be appliable after other conditions', function (): void {

    $user = User::where('email', 'like', '%test%')->verified();

    $expected_sql = 'select * from "users" where "email" like ? and "email_verified_at" is not null';

    expect($user->toSql())->not()->toBe($expected_sql);
});


it('can not apply chain methods', function (): void {

    $user = User::verified()->search('test');

    $expected_sql = 'select * from "users" where "email" like ? and "email_verified_at" is not null';

    expect($user->toSql())->not()->toBe($expected_sql);
});


it('does not apply filter if the method name already exists on the model', function (): void {

    $user =  User::banned();

    $expected_sql = 'select * from "users" where "status" = ?';

    expect($user->toSql())->not()->toBe($expected_sql);
});


it('does not accept filter method as macro', function (): void {

    $user =  User::filter();

    $expected_sql = 'select * from "users"';

    expect($user->toSql())->not()->toBe($expected_sql);
})->throws('ArgumentCountError');
