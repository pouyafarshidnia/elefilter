<?php

use EleFilter\Exceptions\InvalidParameterException;
use Tests\Support\Models\Query;

it('can filter like query', function (): void {

    $query = Query::filter(['likeTest' => 'test']);

    $expected_query = 'select * from "queries" where "title" like ?';

    $bindings = ["%test%"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter not like query', function (): void {

    $query = Query::filter(['notLikeTest' => 'test']);

    $expected_query = 'select * from "queries" where "title" not like ?';

    $bindings = ["%test%"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter equal query', function (): void {

    $query = Query::filter(['EqualTest' => 'test']);

    $expected_query = 'select * from "queries" where "title" = ?';

    $bindings = ["test"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter not equal query', function (): void {

    $query = Query::filter(['NotEqualTest' => 'test']);

    $expected_query = 'select * from "queries" where "title" != ?';

    $bindings = ["test"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter asc query', function (): void {

    $query = Query::filter(['AscTest' => 'apply']);

    $expected_query = 'select * from "queries" order by "created_at" asc';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter desc query', function (): void {

    $query = Query::filter(['DescTest' => 'apply']);

    $expected_query = 'select * from "queries" order by "created_at" desc';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter before today query', function (): void {

    $query = Query::filter(['BeforeTodayTest' => 'apply']);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") < cast(? as text)';

    $bindings = [now()->format('Y-m-d')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter after today query', function (): void {

    $query = Query::filter(['AfterTodayTest' => 'apply']);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") > cast(? as text)';

    $bindings = [now()->format('Y-m-d')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter today or after query', function (): void {

    $query = Query::filter(['TodayOrAfterTest' => 'apply']);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") >= cast(? as text)';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter today or before query', function (): void {

    $query = Query::filter(['TodayOrBeforeTest' => 'apply']);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") <= cast(? as text)';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter today query', function (): void {

    $query = Query::filter(['TodayTest' => 'apply']);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter between query', function (): void {

    $start = now()->subDays(7);
    $end = now();

    $query = Query::filter(['BetweenTest' => [$start, $end]]);

    $expected_query = 'select * from "queries" where "paid_at" between ? and ?';

    $bindings = [$start, $end];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('throws exception if array size of between is not 2', function (): void {
    Query::filter(['BetweenTest' => [1, 2, 3]]);
})->throws(InvalidParameterException::class);


# now() (Carbon instance) Not working yet
it('can filter date query', function (): void {

    $now = now();

    $query = Query::filter(['DateTest' =>  $now->format('Y-m-d H:i:s')]);

    $format = '"%Y-%m-%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    $bindings = [$now->format('Y-m-d H:i:s')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter year query', function (): void {

    $now = now();

    $query = Query::filter(['YearTest' =>  $now->format('Y')]);

    $format = '"%Y"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    $bindings = [$now->format('Y')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});



it('can filter day query', function (): void {

    $now = now();

    $query = Query::filter(['DayTest' =>  $now->format('d')]);

    $format = '"%d"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    $bindings = [$now->format('d')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter end with query', function (): void {

    $query = Query::filter(['EndWithTest' =>  'test']);

    $expected_query = 'select * from "queries" where "title" like ?';

    $bindings = ["%test"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter start with query', function (): void {

    $query = Query::filter(['StartWithTest' =>  'test']);

    $expected_query = 'select * from "queries" where "title" like ?';

    $bindings = ["test%"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});



# Database engine does not support fulltext
it('can filter full text query', function (): void {

    $query = Query::filter(['FullTextTest' =>  'test']);

    $expected_query = 'select * from "queries" where "title" like ?';

    $bindings = ["test"];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
})->throws('RuntimeException');


it('can filter equal or greater than query', function (): void {

    $query = Query::filter(['GreaterOrEqualThanTest' =>  10]);

    $expected_query = 'select * from "queries" where "amount" >= ?';

    $bindings = [10];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter equal or lower than query', function (): void {

    $query = Query::filter(['GreaterOrLowerThanTest' =>  10]);

    $expected_query = 'select * from "queries" where "amount" <> ?';

    $bindings = [10];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter greater than query', function (): void {

    $query = Query::filter(['GreaterThanTest' =>  10]);

    $expected_query = 'select * from "queries" where "amount" > ?';

    $bindings = [10];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter in query', function (): void {

    $query = Query::filter(['InTest' =>  [10, 20, 30]]);

    $expected_query = 'select * from "queries" where "amount" in (?, ?, ?)';

    $bindings = [10, 20, 30];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter not in query', function (): void {

    $query = Query::filter(['NotInTest' =>  [10, 20, 30]]);

    $expected_query = 'select * from "queries" where "amount" not in (?, ?, ?)';

    $bindings = [10, 20, 30];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter lower or equal than query', function (): void {

    $query = Query::filter(['LowerOrEqualThanTest' =>  10]);

    $expected_query = 'select * from "queries" where "amount" <= ?';

    $bindings = [10];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter lower than query', function (): void {

    $query = Query::filter(['LowerThanTest' =>  10]);

    $expected_query = 'select * from "queries" where "amount" < ?';

    $bindings = [10];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter month query', function (): void {

    $now = now();

    $query = Query::filter(['MonthTest' =>  $now->format('m')]);

    $format = '"%m"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    $bindings = [$now->format('m')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter time query', function (): void {

    $now = now();

    $query = Query::filter(['TimeTest' =>  $now->format('H:i:s')]);

    $format = '"%H:%M:%S"';
    $format = str_replace('"', "'", $format);
    $expected_query = 'select * from "queries" where strftime(' . $format . ', "paid_at") = cast(? as text)';

    $bindings = [$now->format('H:i:s')];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('can filter not between query', function (): void {

    $start = now()->subDays(7);
    $end = now();

    $query = Query::filter(['NotBetweenTest' => [$start, $end]]);

    $expected_query = 'select * from "queries" where "paid_at" not between ? and ?';

    $bindings = [$start, $end];

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe($bindings);
});


it('throws exception if array size of not between is not 2', function (): void {
    Query::filter(['NotBetweenTest' => [1, 2, 3]]);
})->throws(InvalidParameterException::class);



it('can filter not null query', function (): void {


    $query = Query::filter(['NotNullTest' => 'apply']);

    $expected_query = 'select * from "queries" where "amount" is not null';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter null query', function (): void {


    $query = Query::filter(['NullTest' => 'apply']);

    $expected_query = 'select * from "queries" where "amount" is null';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter now or future query', function (): void {

    $query = Query::filter(['NowOrFutureTest' =>  'apply']);

    $expected_query = 'select * from "queries" where "paid_at" >= ?';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter now or past query', function (): void {

    $query = Query::filter(['NowOrPastTest' =>  'apply']);

    $expected_query = 'select * from "queries" where "paid_at" <= ?';

    expect($query->toSql())->toBe($expected_query);
});


it('can filter by custom column', function (): void {

    $query = Query::filter(['CustomColumnTest' =>  'test']);

    $expected_query = 'select * from "queries" where "title" = ?';

    expect($query->toSql())->toBe($expected_query)
        ->and($query->getBindings())->toBe(['test']);
});
