
Project Title : BlogApp
Laravel Version : 10.x


1. firstly, you have to clone this project from my github. or I can send the zip file of this project and sql file 
2. And composer install
3. And npm install 
4. And I have already attached sql file name blog.sql inside this root file of this project first you just need to import this sql file in your database.
5. after that you have to run php artisan serve(to start server) and npm run dev(for compilation of css and js).
6. If you have imported my blog.sql file then you have login with these credentials.

   6.1 >>   email - abhishekc9780@gmail.com
            password - 12345678

   6.2 >>  email - diksha@gmail.com
            password - 12345678


route for ui 
============
Route::get('/dashboard', [WebController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/posts/create', [WebController::class, 'create']);
});

Route::get('/', [WebController::class, 'listBlog']);
Route::get('/post/{id}', [WebController::class, 'show']);
Route::get('/posts/{id}', [WebController::class, 'showBlog']);

Route::middleware('auth')->group(function () {
    Route::post('/posts', [WebController::class, 'store']);
    Route::put('/posts/{id}', [WebController::class, 'update']);
    Route::delete('/posts/{id}', [WebController::class, 'destroy']);
    Route::get('/posts/{id}/edit', [WebController::class, 'edit']);
});

Route::post('/comments/{id}', [CommentController::class, 'store'])->middleware('auth');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->middleware('auth');


route for Rest Api 
==================

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);
    Route::get('/posts/{id}', [PostController::class, 'show']);
    Route::post('/posts', [PostController::class, 'store']);
    Route::put('/posts/{id}', [PostController::class, 'update']);
    Route::delete('/posts/{id}', [PostController::class, 'destroy']);
});

Note : - Before running api make sure you have generated a token our wise you will found the error, that,s why please generate token first using (php artisan tinker).

How to generate token. 
======================
$user = \App\Models\User::find(1); // Replace with a valid user ID
$token = $user->createToken('API Token')->plainTextToken;

After generating the token paste this token inside the authorization inside the postman or thunderclient.

I have checked already every module is working properly either ui part or api part .
I have full filled your every requirement in properly .

if any error occurs then contact me .

Note : - I had never used readme.md file before if any problem contact me I will run my project at my system and I will share my screen.


