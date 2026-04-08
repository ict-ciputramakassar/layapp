<?php

use Illuminate\Support\Facades\Route;

// Frontend Routes
Route::get('/', function () {
    return view('views_frontend.home');
})->name('home');

Route::get('/about', function () {
    return view('views_frontend.about');
})->name('about');

Route::get('/team', function () {
    return view('views_frontend.team');
})->name('team');

Route::get('/news', function () {
    return view('views_frontend.news');
})->name('news');

Route::get('/blog', function () {
    return view('views_frontend.blog');
})->name('blog');

Route::get('/contact', function () {
    return view('views_frontend.contact');
})->name('contact');

Route::get('/single-blog', function () {
    return view('views_frontend.single-blog');
})->name('single-blog');
