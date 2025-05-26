<?php

namespace Tests\Unit;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AdminModelTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_admin_with_valid_data()
    {
        $adminData = [
            'nama' => 'Admin Utama',
            'email' => 'admin@school.com',
            'password' => Hash::make('admin123')
        ];

        $admin = Admin::create($adminData);

        $this->assertInstanceOf(Admin::class, $admin);
        $this->assertEquals('Admin Utama', $admin->nama);
        $this->assertEquals('admin@school.com', $admin->email);
        $this->assertTrue(Hash::check('admin123', $admin->password));
    }

    /** @test */
    public function it_has_fillable_attributes()
    {
        $admin = new Admin();
        $fillable = $admin->getFillable();

        $expectedFillable = ['nama', 'email', 'password'];

        $this->assertEquals($expectedFillable, $fillable);
    }

    /** @test */
    public function it_uses_correct_table_name()
    {
        $admin = new Admin();

        $this->assertEquals('admins', $admin->getTable());
    }

    /** @test */
    public function it_can_authenticate_with_password()
    {
        $admin = Admin::create([
            'nama' => 'Test Admin',
            'email' => 'test@admin.com',
            'password' => Hash::make('secret123')
        ]);

        $this->assertTrue(Hash::check('secret123', $admin->getAuthPassword()));
        $this->assertFalse(Hash::check('wrongpassword', $admin->getAuthPassword()));
    }

    /** @test */
    public function it_can_update_admin_credentials()
    {
        $admin = Admin::create([
            'nama' => 'Old Admin',
            'email' => 'old@admin.com',
            'password' => Hash::make('oldpassword')
        ]);

        $admin->update([
            'nama' => 'New Admin',
            'email' => 'new@admin.com',
            'password' => Hash::make('newpassword')
        ]);

        $this->assertEquals('New Admin', $admin->fresh()->nama);
        $this->assertEquals('new@admin.com', $admin->fresh()->email);
        $this->assertTrue(Hash::check('newpassword', $admin->fresh()->password));
    }
}
