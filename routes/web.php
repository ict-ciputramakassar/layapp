<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\AuthController;

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

// Backend Routes - Team Leader
Route::prefix('team_leader')->name('team_leader.')->group(function () {
    Route::get('/add_team_member', [TeamLeaderController::class, 'addMemberView'])->name('add_team_member');

    Route::get('/team_members', function () {
        return view('views_backend.team_leader.team_members');
    })->name('team_members');

    Route::get('/getMembers', [TeamLeaderController::class, 'getMembers'])->name('get_members');
    Route::post('/addMembers', [TeamLeaderController::class, 'addMembersBulk'])->name('add_members_bulk');
});

// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});
