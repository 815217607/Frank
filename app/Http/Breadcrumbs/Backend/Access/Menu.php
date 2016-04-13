<?php

Breadcrumbs::register('admin.access.menus.index', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.dashboard');
    $breadcrumbs->push(trans('labels.backend.access.menus.management'), route('admin.access.menus.index'));
});


Breadcrumbs::register('admin.access.menus.deleted', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.access.menus.index');
    $breadcrumbs->push(trans('menus.backend.access.menus.deleted'), route('admin.access.menus.deleted'));
});

Breadcrumbs::register('admin.access.menus.create', function ($breadcrumbs) {
    $breadcrumbs->parent('admin.access.menus.index');
    $breadcrumbs->push(trans('menus.backend.access.menus.create'), route('admin.access.menus.create'));
});

Breadcrumbs::register('admin.access.menus.edit', function ($breadcrumbs, $id) {
    $breadcrumbs->parent('admin.access.menus.index');
    $breadcrumbs->push(trans('menus.backend.access.menus.edit'), route('admin.access.menus.edit', $id));
});


