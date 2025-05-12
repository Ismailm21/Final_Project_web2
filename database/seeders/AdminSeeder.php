<?php



namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin1@example.com',
            'phone' => '1234567890',
            'password' => Hash::make('12345678'),
            'role' => 'admin',
            'authentication_method' => 'username',
        ]);

    }
}
