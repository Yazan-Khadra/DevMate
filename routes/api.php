<?php


use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\YearController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(JWTAuthController::class)->group(function() {
    Route::post('Register','register');
    Route::post('/user/login','login');

}
);
Route::controller(UserController::class)->group(function() {
    Route::middleware("Token")->group(function() {
        //get user informations
        Route::get('/user/info',"Get_User_Profile_Info");
        //fill the user informatons
        Route::post("/fill/user/info","Fill_Profile_Info");
        // update social links route
        Route::post('/student/social_links/update',"Update_Social_Links");
        // delete social_links
        Route::Delete('/delete/student/social_link',"Delete_social_link");
    });

});
Route::controller(SkillController::class)->group(function(){
    Route::get('skills_list','show_skill');
    Route::get('user_skill','show_user_skill')->middleware('Token');
    Route::post('select_skill','choose_skill')->middleware('Token');
    Route::delete('delete_skill/{id}','delete_skill')->middleware('Token');
});
Route::controller(YearController::class)->group(function(){
    Route::get('year_list', 'show_all_years');
    Route::get('student_by_year/{id}', 'getStudentsByYear');
    Route::get('students_by_major/{majorId}', 'getStudentsByMajor');
});
Route::controller(MajorController::class)->group(function(){
    Route::get('major_list','show_all_majors');
    Route::get('student_by_major/{id}','show_student_by_major');
});
Route::middleware("Token")->group(function () {
    Route::post('/follow/{id}', [FollowController::class, 'follow']);
    Route::post('/unfollow/{id}', [FollowController::class, 'unfollow']);
    Route::get('/followers/{id}', [FollowController::class, 'followers']);
    Route::get('/followings/{id}', [FollowController::class, 'followings']);
});
