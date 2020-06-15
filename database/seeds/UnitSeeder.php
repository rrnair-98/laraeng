<?php

use Illuminate\Database\Seeder;
use App\Features\Courses\Models\Course;
use App\Features\Courses\Models\Unit;
use App\Features\Users\Models\User;
class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach (Course::all() as $course){
            $opsId = User::where("user_role", \App\Features\Sidecar\Users\Constants::USER_ROLE_OPS)->inRandomOrder()->first()->id;
            factory(Unit::class, rand(1,7))->create(['created_by'=>$opsId, 'course_id'=>$course->id]);
        }
    }
}
