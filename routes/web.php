<?php

use App\Http\Controllers\Profile\AvatarController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {

    // list users
    // $users =  DB::select("select * from users");
    //$users = DB::table('users')->get();
    //$users = User::find(11);


    //create a new user
/*     $user = DB::insert("insert into users (name, email, password) values (?, ?, ?)",['one','one@yopamail.com','password'] );

    $user = DB::table('users')->insert([
        'name'=>'two',
        'email'=>'two@yopmail.com',
        'password'=>'password',
    ]); */

    // $user = User::create([
    //     'name'=>'eleven',
    //     'email'=>'eleven@yopmail.com',
    //     'password'=>'password'
    // ]);

    // update a user

    // $user = DB::update("update users set email=? where email=?", ['jayeshguru@yopmail.com', 'jayesh.guru2008@gmail.com']);

    // $user = DB::table('users')->where('id', 3)->update([
    //     'name'=>'jayeshguru1',
    //     'email'=>'jayeshguru1@yopmail.com',
    //     'password'=>'password'
    // ]);

    // $user = User::where('id', 4)->update([
    //     'email'=>'jayeshguru123@yopmail.com'
    // ]);

    // Delete a user
    // $user = DB::delete("delete from users where id=?",[2]);

    // $user = DB::table('users')->where('id', 3)->delete();

    // $user = User::where('id', 4)->delete();

    //dd($users->name);
    return view('welcome');
});
// Route::get('/openai', function(){
//     $result = OpenAI::images()->create([
//         'prompt' => 'Avatar image',
//         'size'=>"256x256",
//         'n'=>1
//     ]);

//     echo '<img src="'.$result->data[0]->url.'" >';
// });

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [AvatarController::class, 'update'])->name('profile.avatar');
    Route::patch('/profile/avatar/ai', [AvatarController::class, 'generate_avatar'])->name('profile.avatar.ai');
});

Route::post('/auth/redirect', function () {
    return Socialite::driver('github')->redirect();
})->name('login.github');

Route::get('/auth/callback', function () {
    $user = Socialite::driver('github')->user();
    $user = User::firstOrcreate(['email'=>$user->email],[
        'name'=>$user->name,
        'password'=>'password'
    ]);
    Auth::login($user);
    return redirect('/dashboard');
    // $user->token
});
Route::middleware('auth')->group(function(){
    //Route::get('ticket.create', [TicketController::class, 'create']);
    Route::resource('ticket', TicketController::class);
});


require __DIR__.'/auth.php';
