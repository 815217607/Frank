<?php

Breadcrumbs::register('admin.access.permissions.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('menus.backend.access.permissions.management'), route('admin.access.permissions.index'));
});

Breadcrumbs::register('admin.access.permissions.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.access.permissions.index');
    $breadcrumbs->push(trans('menus.backend.access.permissions.create'), route('admin.access.permissions.create'));
});

Breadcrumbs::register('admin.access.permissions.edit', function ($breadcrumbs, $perm) {
    $breadcrumbs->parent('admin.access.permissions.index');
    $breadcrumbs->push(trans('menus.backend.access.permissions.edit'), route('admin.access.permissions.edit', $perm));
});