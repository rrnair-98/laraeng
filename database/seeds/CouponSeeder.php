<?php

use Illuminate\Database\Seeder;
use App\Features\Users\Models\User;
use App\Features\Marketplace\Models\Coupon;
class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $user = User::where("user_role", \App\Features\Sidecar\Users\Constants::USER_ROLE_OPS)->inRandomOrder()->first();
        factory(Coupon::class, 4)->create(["created_by"=>$user->id]);
    }
}
