<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\EventController;

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

Route::get('/events', [EventController::class, 'viewEventList'])->name('events');
Route::post('/event/register', [EventController::class, 'registerTeam'])->name('api.event.register');

Route::get('/api/events-frontend', [EventController::class, 'getEventsFrontend'])->name('api.events-frontend');
Route::get('/api/points-frontend', [EventController::class, 'getTeamPointsFrontend'])->name('api.points-frontend');

Route::get('/team_datas', [TeamLeaderController::class, 'getTeams'])->name('team_datas');
Route::get('/team/{id}', [TeamLeaderController::class, 'viewTeamDetails'])->name('team_details');

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
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    // File Upload
    Route::post('/upload', [UploadController::class, 'store'])->name('upload');

    // Main Navigation
    Route::get('/dashboard', function () {
        return view('views_backend.dashboard');
    })->name('dashboard');

    Route::get('/event-list', [EventController::class, 'index'])->name('event-list');

    Route::get('/reports', function () {
        return view('views_backend.reports');
    })->name('reports');

    // Event Management
    Route::get('/create-event', [EventController::class, 'create'])->name('create-event');
    Route::post('/events', [EventController::class, 'store'])->name('events.store');
    Route::get('/api/events', [EventController::class, 'getEventsData'])->name('api.events.data');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');

    Route::get('/edit-product', function () {
        return view('views_backend.edit-product');
    })->name('edit-product');

    Route::get('/product-details', function () {
        return view('views_backend.product-details');
    })->name('product-details');

    Route::get('/product-categories', function () {
        return view('views_backend.product-categories');
    })->name('product-categories');

    Route::get('/product-brands', function () {
        return view('views_backend.product-brands');
    })->name('product-brands');

    Route::get('/product-variants', function () {
        return view('views_backend.product-variants');
    })->name('product-variants');

    // Inventory & Stock Management
    Route::get('/stock-overview', function () {
        return view('views_backend.stock-overview');
    })->name('stock-overview');

    Route::get('/stock-in', function () {
        return view('views_backend.stock-in');
    })->name('stock-in');

    Route::get('/stock-out', function () {
        return view('views_backend.stock-out');
    })->name('stock-out');

    Route::get('/low-stock-products', function () {
        return view('views_backend.low-stock-products');
    })->name('low-stock-products');

    Route::get('/stock-expired', function () {
        return view('views_backend.stock-expired');
    })->name('stock-expired');

    Route::get('/warehouse-location-management', function () {
        return view('views_backend.warehouse-location-management');
    })->name('warehouse-location-management');

    // Orders & Sales
    Route::get('/order-list', function () {
        return view('views_backend.order-list');
    })->name('order-list');

    Route::get('/order-details', function () {
        return view('views_backend.order-details');
    })->name('order-details');

    Route::get('/create-order', function () {
        return view('views_backend.create-order');
    })->name('create-order');

    Route::get('/invoice', function () {
        return view('views_backend.invoice');
    })->name('invoice');

    Route::get('/returns-refunds', function () {
        return view('views_backend.returns-refunds');
    })->name('returns-refunds');

    Route::get('/pos', function () {
        return view('views_backend.pos');
    })->name('pos');

    // Account & Users
    Route::get('/user-roles', [UserRolesController::class, 'index'])->name('user-roles')->middleware('superadmin');
    Route::get('/api/users', [UserRolesController::class, 'getUsers'])->name('api.users')->middleware('superadmin');
    Route::get('/api/roles', [UserRolesController::class, 'getRoles'])->name('api.roles')->middleware('superadmin');
    Route::post('/users', [UserRolesController::class, 'storeUser'])->name('users.store')->middleware('superadmin');
    Route::put('/users/{userId}', [UserRolesController::class, 'updateUser'])->name('users.update')->middleware('superadmin');
    Route::put('/users/{userId}/role', [UserRolesController::class, 'updateUserRole'])->name('users.updateRole')->middleware('superadmin');
    Route::delete('/users/{userId}', [UserRolesController::class, 'deleteUser'])->name('users.delete')->middleware('superadmin');
    Route::post('/roles', [UserRolesController::class, 'storeRole'])->name('roles.store')->middleware('superadmin');
    Route::put('/roles/{roleId}', [UserRolesController::class, 'updateRole'])->name('roles.update')->middleware('superadmin');
    Route::delete('/roles/{roleId}', [UserRolesController::class, 'deleteRole'])->name('roles.delete')->middleware('superadmin');

    // Utilities
    Route::get('/404', function () {
        return view('views_backend.error-404');
    })->name('error-404');

    Route::get('/docs', function () {
        return view('views_backend.docs');
    })->name('docs');

    Route::get('/changelog', function () {
        return view('views_backend.changelog');
    })->name('changelog');
});

// Backend Routes - Team Leader
Route::prefix('team_leader')->name('team_leader.')->middleware("teamleader")->group(function () {
    Route::get('/add_team_member', [TeamLeaderController::class, 'addMemberView'])->name('add_team_member');

    Route::get('/team_members', [TeamLeaderController::class, 'viewTeamMembers'])->name('team_members');

    Route::get('/getAthletes/{eventId}', [TeamLeaderController::class, 'getAthletesForRegistration'])->name('get_athlete');
    Route::get('/getMembers', [TeamLeaderController::class, 'getMembers'])->name('get_members');
    Route::post('/addMembers', [TeamLeaderController::class, 'addMembersBulk'])->name('add_members_bulk');
    Route::get('/getMember/{id}', [TeamLeaderController::class, 'getMemberById'])->name('get_member_by_id');
    Route::get('/editMember/{id}', [TeamLeaderController::class, 'editMemberView'])->name('edit_member');
    Route::put('/updateMember/{id}', [TeamLeaderController::class, 'updateMember'])->name('update_member');
    Route::delete('/deleteMember/{id}', [TeamLeaderController::class, 'deleteMember'])->name('delete_member');
});

// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::get('/admin/signin', [AuthController::class, 'login'])->name('admin.signin');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/admin/signup', [AuthController::class, 'signup'])->name('admin.signup');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
