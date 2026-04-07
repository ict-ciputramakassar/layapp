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



// Backend Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', function () {
        return view('views_backend.dashboard');
    })->name('dashboard');

    Route::get('/inventory', function () {
        return view('views_backend.inventory');
    })->name('inventory');

    Route::get('/create-product', function () {
        return view('views_backend.create-product');
    })->name('create-product');

    Route::get('/reports', function () {
        return view('views_backend.reports');
    })->name('reports');

    Route::get('/docs', function () {
        return view('views_backend.docs');
    })->name('docs');

    Route::get('/404', function () {
        return view('views_backend.error-404');
    })->name('error-404');

    Route::get('/signin', function () {
        return view('views_backend.signin');
    })->name('signin');

    Route::get('/signup', function () {
        return view('views_backend.signup');
    })->name('signup');
});
