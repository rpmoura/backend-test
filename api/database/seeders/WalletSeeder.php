<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        $users->map(function (User $user) {
            $wallet          = new Wallet();
            $wallet->uuid    = Str::uuid();
            $wallet->user_id = $user->id;
            $wallet->amount  = rand(0, 9999);
            $wallet->save();
        });
    }
}
