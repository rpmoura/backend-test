<?php

namespace Database\Seeders;

use App\Enums\UserTypeEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user           = new User();
        $user->uuid     = Str::uuid();
        $user->name     = 'Usuário Comum';
        $user->cpf_cnpj = '12345678900';
        $user->email    = 'usuario@email.com';
        $user->password = bcrypt('secret');
        $user->type     = UserTypeEnum::COMMON;
        $user->save();

        $user           = new User();
        $user->uuid     = Str::uuid();
        $user->name     = 'Usuário Lojista';
        $user->cpf_cnpj = '12345678000155';
        $user->email    = 'lojista@email.com';
        $user->password = bcrypt('secret');
        $user->type     = UserTypeEnum::SHOPKEEPER;
        $user->save();
    }
}
