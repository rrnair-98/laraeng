<?php

use Illuminate\Database\Seeder;
use App\Features\Users\Models\User;
use App\Features\Marketplace\Models\Cart;
use App\Features\Marketplace\Models\CartCourse;
class CartSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach (User::where("user_role", \App\Features\Sidecar\Users\Constants::USER_ROLE_STUDENT)->get() as $student){
            factory(Cart::class, rand(1,3))->create(["created_by"=>$student->id])->each(
                function($cart) use (&$student){
                    $cart->cartCourses()->saveMany(
                        factory(CartCourse::class, rand(2, 5))->create([
                            "cart_id"       => $cart->id,
                            "created_by"    => $student->id
                        ])
                    )->make();
                }
            );
        }
    }
}
