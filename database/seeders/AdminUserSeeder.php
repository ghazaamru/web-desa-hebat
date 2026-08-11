<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email = env('ADMIN_EMAIL', 'admin@dalangan.desa.id');
        $password = env('ADMIN_PASSWORD', Str::password(16));

        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => env('ADMIN_NAME', 'Administrator Desa'),
                'email_verified_at' => now(),
                'password' => $password,
                'is_admin' => true,
            ]
        );

        $this->command?->info("Akun admin: {$email}");
        if (env('ADMIN_PASSWORD') === false || is_null(env('ADMIN_PASSWORD'))) {
            $this->command?->warn("ADMIN_PASSWORD belum diatur di .env, password sementara: {$password}");
        }
    }
}
