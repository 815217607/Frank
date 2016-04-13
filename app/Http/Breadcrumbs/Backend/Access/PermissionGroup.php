<?php

Breadcrumbs::register('admin.access.groups.permission-group.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.access.permissions.groups.management'), route('admin.access.groups.permission-group.index'));
});


Breadcrumbs::register('admin.access.groups.permission-group.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.access.groups.permission-group.index');
    $breadcrumbs->push(trans('menus.backend.access.permissions.groups.create'), route('admin.access.groups.permission-group.create'));
});

Breadcrumbs::register('admin.access.groups.permission-group.edit', function ($breadcrumbs, $group) {
    $breadcrumbs->parent('admin.access.groups.permission-group.index');
    $breadcrumbs->push(trans('menus.backend.access.permissions.groups.edit'), route('admin.access.groups.permission-group.edit', $group));
});

//
//
//Breadcrumbs::register('admin.access.groups.permission-group.create', function ($breadcrumbs) {
//    $breadcrumbs->parent('admin.access.groups.permissions.index');
//    $breadcrumbs->push(trans('menus.backend.access.permissions.groups.create'), route('admin.access.groups.permission-group.create'));
//});
//
//Breadcrumbs::register('admin.access.groups.permission-group.edit', function ($breadcrumbs, $group) {
//    $breadcrumbs->parent('admin.access.groups.permissions.index');
//    $breadcrumbs->push(trans('menus.backend.access.permissions.groups.edit'), route('admin.access.groups.permission-group.edit', $group));
//});