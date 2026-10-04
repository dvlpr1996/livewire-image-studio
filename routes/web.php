<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home')->name('home');

Route::livewire('/history', 'pages::history')->name('history');
Route::livewire('/api', 'pages::api-docs')->name('api.docs');

// Route::livewire('/studio', 'pages::studio')->name('studio');
