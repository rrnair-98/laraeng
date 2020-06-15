<?php

use Illuminate\Database\Seeder;
use App\Features\Users\Models\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(User::class, 5)->create(['user_role' =>\App\Features\Sidecar\Users\Constants::USER_ROLE_OPS]);
        factory(User::class, 50)->create(['user_role'=>\App\Features\Sidecar\Users\Constants::USER_ROLE_STUDENT]);
        factory(User::class, 30)->create(['user_role'=>\App\Features\Sidecar\Users\Constants::USER_ROLE_TEACHER]);
    }
}
