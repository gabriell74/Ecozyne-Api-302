<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class UserModelTest extends TestCase
{
    public function test_dapat_membuat_user_baru(): void
    {
        // Arrange & Act
        $user = User::create([
            'username' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Assert
        $this->assertDatabaseHas('users', [
            'username' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
        ]);
        $this->assertNotNull($user->id);
    }

    public function test_dapat_mengambil_user_berdasarkan_id(): void
    {
        // Arrange: Buat user menggunakan Factory
        $user = User::factory()->create([
            'username' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // Act
        $foundUser = User::find($user->id);

        // Assert
        $this->assertNotNull($foundUser);
        $this->assertEquals('John Doe', $foundUser->username);
        $this->assertEquals($user->id, $foundUser->id);
    }
    
    public function test_dapat_update_user(): void
    {
        $user = User::factory()->create();

        $user->update(['username' => 'Updated Name']);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'username' => 'Updated Name',
        ]);
    }

    public function test_dapat_delete_user(): void
    {
        $user = User::factory()->create();
        $userId = $user->id;

        $user->delete();

        $this->assertDatabaseMissing('users', ['id' => $userId]);
    }
}