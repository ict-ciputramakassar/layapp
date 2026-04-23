<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TeamLeaderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserRolesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\ScoreController;
use App\Http\Controllers\GroupController;

// Frontend Routes
Route::get('/', [ScheduleController::class, 'frontendHome'])->name('home');

Route::get('/about', function () {
    return view('views_frontend.about');
})->name('about');

Route::get('/team', function () {
    return view('views_frontend.team');
})->name('team');

Route::get('/events', [EventController::class, 'viewEventList'])->name('events');
Route::post('/event/register', [EventController::class, 'registerTeam'])->name('api.event.register');

Route::get('/api/events-frontend', [EventController::class, 'getEventsFrontend'])->name('api.events-frontend');
Route::get('/api/points-frontend', [GroupController::class, 'getTeamPointsFrontend'])->name('api.points-frontend');

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
Route::middleware('auth')->group(function () {
    // Main
    Route::get('/dashboard', function () {
        return view('views_backend.dashboard');
    })->name('dashboard');

    Route::get('/reports', function () {
        return view('views_backend.reports');
    })->name('reports');

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

// Secure Backend Routes
Route::middleware('auth')->group(function () {

    // User Roles Management
    Route::middleware('permission:user_roles')->group(function () {
        Route::get('/user-roles', [UserRolesController::class, 'index'])->name('user-roles');
        Route::get('/api/users', [UserRolesController::class, 'getUsers'])->name('api.users');
        Route::get('/api/roles', [UserRolesController::class, 'getRoles'])->name('api.roles');
        Route::post('/users', [UserRolesController::class, 'storeUser'])->name('users.store');
        Route::put('/users/{userId}', [UserRolesController::class, 'updateUser'])->name('users.update');
        Route::put('/users/{userId}/role', [UserRolesController::class, 'updateUserRole'])->name('users.updateRole');
        Route::delete('/users/{userId}', [UserRolesController::class, 'deleteUser'])->name('users.delete');
        Route::post('/roles', [UserRolesController::class, 'storeRole'])->name('roles.store');
        Route::put('/roles/{roleId}', [UserRolesController::class, 'updateRole'])->name('roles.update');
        Route::delete('/roles/{roleId}', [UserRolesController::class, 'deleteRole'])->name('roles.delete');
    });

    // Event Management
    Route::middleware('permission:event_list')->group(function () {
        Route::get('/create-event', [EventController::class, 'create'])->name('create-event')->middleware('permission:create_event');
        Route::post('/events', [EventController::class, 'store'])->name('events.store')->middleware('permission:create_event');
        Route::get('/event-list', [EventController::class, 'index'])->name('event-list');
        Route::get('/api/events', [EventController::class, 'getEventsData'])->name('api.events.data');
        Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
        Route::get('/events/{event}/edit', [EventController::class, 'edit'])->name('events.edit');
        Route::put('/events/{event}', [EventController::class, 'update'])->name('events.update');
        Route::delete('/events/{event}', [EventController::class, 'destroy'])->name('events.destroy');
    });

    // Schedule Management
    Route::middleware('permission:create_schedule')->group(function () {
        Route::get('/create-schedule', [ScheduleController::class, 'create'])->name('create-schedule');
        Route::get('/schedule-list', [ScheduleController::class, 'index'])->name('schedule-list')->middleware('permission:schedule_list');
        Route::post('/schedule', [ScheduleController::class, 'store'])->name('schedule.store');
        Route::get('/api/schedule/list', [ScheduleController::class, 'list'])->name('api.schedule.list');
        Route::get('/schedule/{schedule}/edit', [ScheduleController::class, 'edit'])->name('schedule.edit');
        Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
        Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
        Route::get('/api/schedule/teams-events', [ScheduleController::class, 'getTeamsAndEvents'])->name('schedule.getTeamsAndEvents');
    });

    // Team Management
    Route::middleware('permission:team_members')->group(function () {
        Route::get('/add_team_member', [TeamLeaderController::class, 'addMemberView'])->name('add_team_member')->middleware('permission:add_team_members');
        Route::post('/addMembers', [TeamLeaderController::class, 'addMembersBulk'])->name('add_members_bulk')->middleware('permission:add_team_members');
        Route::get('/team_members', [TeamLeaderController::class, 'viewTeamMembers'])->name('team_members');
        Route::get('/getAthletes/{eventId}', [TeamLeaderController::class, 'getAthletesForRegistration'])->name('get_athlete');
        Route::get('/getMembers', [TeamLeaderController::class, 'getMembers'])->name('get_members');
        Route::get('/getMember/{id}', [TeamLeaderController::class, 'getMemberById'])->name('get_member_by_id');
        Route::get('/editMember/{id}', [TeamLeaderController::class, 'editMemberView'])->name('edit_member');
        Route::put('/updateMember/{id}', [TeamLeaderController::class, 'updateMember'])->name('update_member');
        Route::delete('/deleteMember/{id}', [TeamLeaderController::class, 'deleteMember'])->name('delete_member');
    });

    // Score Management
    Route::middleware('permission:score_list')->group(function () {
        Route::get('/score-list', [ScoreController::class, 'index'])->name('score-list');
        Route::get('/api/score/list', [ScoreController::class, 'list'])->name('api.score.list');
        Route::get('/score/{score}/edit', [ScoreController::class, 'edit'])->name('score.edit');
        Route::put('/score/{score}', [ScoreController::class, 'update'])->name('score.update');
    });

    // Group Management
    Route::middleware('permission:group_list')->group(function () {
        Route::get('/group-list', [GroupController::class, 'index'])->name('group-list');
        Route::get('/create-group', [GroupController::class, 'create'])->name('create-group');
        Route::get('/group/{group}/edit', [GroupController::class, 'edit'])->name('group.edit');
        Route::put('/group/{group}', [GroupController::class, 'update'])->name('group.update');
        Route::delete('/group/{group}', [GroupController::class, 'destroy'])->name('group.destroy');
        Route::post('/group', [GroupController::class, 'store'])->name('group.store');
        Route::get('/api/groups/data', [GroupController::class, 'getGroupsData'])->name('api.groups.data');
        Route::get('/api/group/points-frontend', [GroupController::class, 'getTeamPointsFrontend'])->name('api.group.points-frontend');
    });
});

// Auth Routes
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
