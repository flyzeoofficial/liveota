<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Post;
use App\Livewire\HelloWorld;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', Helloworld::class);
Route::get('/post', Post::class);
