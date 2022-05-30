<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPermission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (range(0, 10) as $id) {
            $idText = $id > 0 ? $id : '';

            if (env("DEFAULT_ADMIN_NAME{$idText}") && env("DEFAULT_ADMIN_EMAIL{$idText}")) {
                $name = ucwords(trim(env("DEFAULT_ADMIN_NAME{$idText}")));
                $email = trim(env("DEFAULT_ADMIN_EMAIL{$idText}"));
                $password = Hash::make(env('DEFAULT_ADMIN_PASS', "P@55w0rd123"));

                $user = User::create([
                    'name' => $name,
                    'email' => $email,
                    'password' => $password,
                    'images_id' => null,
                ]);

                if ($user) {
                    $permission = UserPermission::create(
                        array_merge(
                            ['users_id' => $user->id],
                            UserPermission::ADMIN
                        )
                    );
                    if (!$permission->save()) $user->delete();
                }
            }
        }
    }
}
