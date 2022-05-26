<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.

use App\Http\Controllers\TagController;
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;


Breadcrumbs::for('tags', function (BreadcrumbTrail $trail) {
    $trail->push('Tags', route('tags.index'));
});

Breadcrumbs::for('create_tag', function (BreadcrumbTrail $trail) {
    $trail->parent('tags');
    $trail->push('Create Tag', route('tags.create'));
});

Breadcrumbs::for('offers', function (BreadcrumbTrail $trail) {
    $trail->push('Offers', route('offers.index'));
});

Breadcrumbs::for('create_offer', function (BreadcrumbTrail $trail) {
    $trail->parent('offers');
    $trail->push('Add Offer', route('offers.create'));
});

Breadcrumbs::for('view_offer', function (BreadcrumbTrail $trail, $title) {
    $trail->parent('offers');
    $trail->push($title, route('offers.create'));
});
