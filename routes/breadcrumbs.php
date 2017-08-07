<?php

// Home
Breadcrumbs::register('home', function($breadcrumbs){
  $breadcrumbs->push('Home', route('home'));
});

// Menu
Breadcrumbs::register('menu', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Daftar Menu', route('menu.index'));
});

Breadcrumbs::register('menu.create', function($breadcrumbs){
  $breadcrumbs->parent('menu');
  $breadcrumbs->push('+ Tambah Menu', route('menu.create'));
});

Breadcrumbs::register('menu.show', function($breadcrumbs, $menu){
  $breadcrumbs->parent('menu');
  $breadcrumbs->push($menu->name, route('menu.show', $menu->kode_menu));
});

Breadcrumbs::register('menu.edit', function($breadcrumbs, $menu){
  $breadcrumbs->parent('menu');
  $breadcrumbs->push('Edit Menu - ' . $menu->name, route('menu.edit', $menu->kode_menu));
});

// Transaction
Breadcrumbs::register('transaction', function($breadcrumbs){
  $breadcrumbs->parent('home');
  $breadcrumbs->push('Create Transaction', route('transaction.index'));
});
