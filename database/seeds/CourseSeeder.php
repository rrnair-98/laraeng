<?php

use App\Features\Users\Models\User;
use Illuminate\Database\Seeder;
use App\Features\Courses\Models\Course;
class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach (User::where("user_role", \App\Features\Sidecar\Users\Constants::USER_ROLE_OPS)->get() as $user){
            factory(Course::class, rand(1,7))->create(['created_by'=>$user->id]);
        }
    }
}
