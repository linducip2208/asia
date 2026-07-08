<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    private array $permissionDefs = [
        // Master Data
        ['name' => 'Lihat Master Data', 'slug' => 'view-master-data', 'group' => 'master-data'],
        ['name' => 'Buat Master Data', 'slug' => 'create-master-data', 'group' => 'master-data'],
        ['name' => 'Edit Master Data', 'slug' => 'edit-master-data', 'group' => 'master-data'],
        ['name' => 'Hapus Master Data', 'slug' => 'delete-master-data', 'group' => 'master-data'],

        // Transaksi / Penjualan
        ['name' => 'Lihat Transaksi', 'slug' => 'view-transaksi', 'group' => 'transaksi'],
        ['name' => 'Buat Transaksi', 'slug' => 'create-transaksi', 'group' => 'transaksi'],
        ['name' => 'Edit Transaksi', 'slug' => 'edit-transaksi', 'group' => 'transaksi'],
        ['name' => 'Hapus Transaksi', 'slug' => 'delete-transaksi', 'group' => 'transaksi'],

        // Pembelian
        ['name' => 'Lihat Pembelian', 'slug' => 'view-pembelian', 'group' => 'pembelian'],
        ['name' => 'Buat Pembelian', 'slug' => 'create-pembelian', 'group' => 'pembelian'],
        ['name' => 'Edit Pembelian', 'slug' => 'edit-pembelian', 'group' => 'pembelian'],
        ['name' => 'Hapus Pembelian', 'slug' => 'delete-pembelian', 'group' => 'pembelian'],

        // Keuangan (Finance) — Full
        ['name' => 'Lihat Keuangan', 'slug' => 'view-finance', 'group' => 'finance'],
        ['name' => 'Buat Keuangan', 'slug' => 'create-finance', 'group' => 'finance'],
        ['name' => 'Edit Keuangan', 'slug' => 'edit-finance', 'group' => 'finance'],
        ['name' => 'Hapus Keuangan', 'slug' => 'delete-finance', 'group' => 'finance'],

        // Inventori
        ['name' => 'Lihat Inventori', 'slug' => 'view-inventori', 'group' => 'inventori'],
        ['name' => 'Buat Inventori', 'slug' => 'create-inventori', 'group' => 'inventori'],
        ['name' => 'Edit Inventori', 'slug' => 'edit-inventori', 'group' => 'inventori'],
        ['name' => 'Hapus Inventori', 'slug' => 'delete-inventori', 'group' => 'inventori'],

        // Operasional
        ['name' => 'Lihat Operasional', 'slug' => 'view-operasional', 'group' => 'operasional'],
        ['name' => 'Buat Operasional', 'slug' => 'create-operasional', 'group' => 'operasional'],
        ['name' => 'Edit Operasional', 'slug' => 'edit-operasional', 'group' => 'operasional'],
        ['name' => 'Hapus Operasional', 'slug' => 'delete-operasional', 'group' => 'operasional'],

        // Loyalitas / CRM
        ['name' => 'Lihat Loyalitas', 'slug' => 'view-loyalitas', 'group' => 'loyalitas'],
        ['name' => 'Buat Loyalitas', 'slug' => 'create-loyalitas', 'group' => 'loyalitas'],
        ['name' => 'Edit Loyalitas', 'slug' => 'edit-loyalitas', 'group' => 'loyalitas'],
        ['name' => 'Hapus Loyalitas', 'slug' => 'delete-loyalitas', 'group' => 'loyalitas'],

        // Laporan
        ['name' => 'Lihat Laporan', 'slug' => 'view-laporan', 'group' => 'laporan'],
        ['name' => 'Export Laporan', 'slug' => 'export-laporan', 'group' => 'laporan'],

        // Marketing / Promo
        ['name' => 'Lihat Marketing', 'slug' => 'view-marketing', 'group' => 'marketing'],
        ['name' => 'Buat Marketing', 'slug' => 'create-marketing', 'group' => 'marketing'],
        ['name' => 'Edit Marketing', 'slug' => 'edit-marketing', 'group' => 'marketing'],
        ['name' => 'Hapus Marketing', 'slug' => 'delete-marketing', 'group' => 'marketing'],

        // Produksi / Manufaktur
        ['name' => 'Lihat Produksi', 'slug' => 'view-produksi', 'group' => 'produksi'],
        ['name' => 'Buat Produksi', 'slug' => 'create-produksi', 'group' => 'produksi'],
        ['name' => 'Edit Produksi', 'slug' => 'edit-produksi', 'group' => 'produksi'],
        ['name' => 'Hapus Produksi', 'slug' => 'delete-produksi', 'group' => 'produksi'],

        // Integrasi
        ['name' => 'Lihat Integrasi', 'slug' => 'view-integrasi', 'group' => 'integrasi'],
        ['name' => 'Buat Integrasi', 'slug' => 'create-integrasi', 'group' => 'integrasi'],
        ['name' => 'Edit Integrasi', 'slug' => 'edit-integrasi', 'group' => 'integrasi'],
        ['name' => 'Hapus Integrasi', 'slug' => 'delete-integrasi', 'group' => 'integrasi'],

        // Notifikasi
        ['name' => 'Lihat Notifikasi', 'slug' => 'view-notifikasi', 'group' => 'notifikasi'],
        ['name' => 'Kelola Notifikasi', 'slug' => 'manage-notifikasi', 'group' => 'notifikasi'],

        // HR / Pegawai
        ['name' => 'Lihat Pegawai', 'slug' => 'view-pegawai', 'group' => 'pegawai'],
        ['name' => 'Buat Pegawai', 'slug' => 'create-pegawai', 'group' => 'pegawai'],
        ['name' => 'Edit Pegawai', 'slug' => 'edit-pegawai', 'group' => 'pegawai'],
        ['name' => 'Hapus Pegawai', 'slug' => 'delete-pegawai', 'group' => 'pegawai'],

        // Sistem
        ['name' => 'Lihat Sistem', 'slug' => 'view-sistem', 'group' => 'sistem'],
        ['name' => 'Buat Sistem', 'slug' => 'create-sistem', 'group' => 'sistem'],
        ['name' => 'Edit Sistem', 'slug' => 'edit-sistem', 'group' => 'sistem'],
        ['name' => 'Hapus Sistem', 'slug' => 'delete-sistem', 'group' => 'sistem'],

        // Super Admin
        ['name' => 'Kelola Tenant', 'slug' => 'manage-tenants', 'group' => 'super'],
        ['name' => 'Kelola Subscription', 'slug' => 'manage-subscriptions', 'group' => 'super'],
        ['name' => 'Kelola White Label', 'slug' => 'manage-whitelabel', 'group' => 'super'],
        ['name' => 'Akses Super Panel', 'slug' => 'super-panel-access', 'group' => 'super'],

        // Special
        ['name' => 'Akses POS Kasir', 'slug' => 'pos-access', 'group' => 'special'],
        ['name' => 'Akses Dashboard', 'slug' => 'dashboard-access', 'group' => 'special'],
        ['name' => 'Super Admin', 'slug' => '*', 'group' => 'special'],
    ];

    public function run(): void
    {
        $this->command->info('Seeding roles & permissions...');

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('role_user')->truncate();
        DB::table('role_permission')->truncate();
        DB::table('permissions')->truncate();
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $permissionMap = [];
        foreach ($this->permissionDefs as $def) {
            $permissionMap[$def['slug']] = Permission::create($def)->id;
        }

        $roles = [
            'super_admin' => [
                'name' => 'Super Admin',
                'description' => 'Platform owner — akses penuh Super Admin Panel & semua tenant',
                'is_system' => true,
                'permissions' => ['*'],
            ],
            'owner' => [
                'name' => 'Owner',
                'description' => 'Pemilik bisnis — akses penuh ke semua fitur tenant & laporan',
                'is_system' => true,
                'permissions' => [
                    'view-master-data', 'create-master-data', 'edit-master-data', 'delete-master-data',
                    'view-transaksi', 'create-transaksi', 'edit-transaksi', 'delete-transaksi',
                    'view-pembelian', 'create-pembelian', 'edit-pembelian', 'delete-pembelian',
                    'view-finance', 'create-finance', 'edit-finance', 'delete-finance',
                    'view-inventori', 'create-inventori', 'edit-inventori', 'delete-inventori',
                    'view-operasional', 'create-operasional', 'edit-operasional', 'delete-operasional',
                    'view-loyalitas', 'create-loyalitas', 'edit-loyalitas', 'delete-loyalitas',
                    'view-laporan', 'export-laporan',
                    'view-marketing', 'create-marketing', 'edit-marketing', 'delete-marketing',
                    'view-produksi', 'create-produksi', 'edit-produksi', 'delete-produksi',
                    'view-integrasi', 'create-integrasi', 'edit-integrasi', 'delete-integrasi',
                    'view-notifikasi', 'manage-notifikasi',
                    'view-pegawai', 'create-pegawai', 'edit-pegawai', 'delete-pegawai',
                    'view-sistem', 'edit-sistem',
                    'pos-access', 'dashboard-access',
                ],
            ],
            'manager' => [
                'name' => 'Manager',
                'description' => 'Manajer operasional — kelola transaksi, stok, laporan, karyawan',
                'is_system' => true,
                'permissions' => [
                    'view-master-data', 'create-master-data', 'edit-master-data',
                    'view-transaksi', 'create-transaksi', 'edit-transaksi', 'delete-transaksi',
                    'view-pembelian', 'create-pembelian', 'edit-pembelian',
                    'view-finance', 'create-finance', 'edit-finance',
                    'view-inventori', 'create-inventori', 'edit-inventori',
                    'view-operasional', 'create-operasional', 'edit-operasional',
                    'view-loyalitas', 'create-loyalitas', 'edit-loyalitas',
                    'view-laporan', 'export-laporan',
                    'view-marketing', 'create-marketing', 'edit-marketing',
                    'view-produksi', 'create-produksi', 'edit-produksi',
                    'view-sistem', 'edit-sistem',
                    'view-pegawai', 'edit-pegawai',
                    'view-notifikasi',
                    'pos-access', 'dashboard-access',
                ],
            ],
            'admin' => [
                'name' => 'Admin',
                'description' => 'Administrator — kelola master data, transaksi, stok, laporan',
                'is_system' => true,
                'permissions' => [
                    'view-master-data', 'create-master-data', 'edit-master-data',
                    'view-transaksi', 'create-transaksi', 'edit-transaksi',
                    'view-pembelian', 'create-pembelian',
                    'view-finance',
                    'view-inventori', 'create-inventori', 'edit-inventori',
                    'view-operasional',
                    'view-loyalitas', 'create-loyalitas',
                    'view-laporan',
                    'view-marketing',
                    'view-sistem',
                    'pos-access', 'dashboard-access',
                ],
            ],
            'kasir' => [
                'name' => 'Kasir',
                'description' => 'Kasir — akses POS, lihat transaksi & stok',
                'is_system' => true,
                'permissions' => [
                    'view-transaksi', 'create-transaksi',
                    'view-inventori',
                    'view-operasional',
                    'pos-access',
                ],
            ],
            'gudang' => [
                'name' => 'Gudang',
                'description' => 'Staff gudang — kelola stok, pembelian, stock opname',
                'is_system' => true,
                'permissions' => [
                    'view-master-data',
                    'view-pembelian', 'create-pembelian', 'edit-pembelian',
                    'view-inventori', 'create-inventori', 'edit-inventori',
                    'view-operasional',
                    'dashboard-access',
                ],
            ],
            'keuangan' => [
                'name' => 'Keuangan',
                'description' => 'Staff keuangan — kelola COA, jurnal, kas, bank, rekonsiliasi',
                'is_system' => true,
                'permissions' => [
                    'view-finance', 'create-finance', 'edit-finance',
                    'view-laporan', 'export-laporan',
                    'view-master-data',
                    'dashboard-access',
                ],
            ],
        ];

        $roleModels = [];
        foreach ($roles as $slug => $def) {
            $role = Role::create([
                'name' => $def['name'],
                'slug' => $slug,
                'description' => $def['description'],
                'is_system' => $def['is_system'],
            ]);

            $permIds = [];
            foreach ($def['permissions'] as $permSlug) {
                if ($permSlug === '*') {
                    $permIds = array_values($permissionMap);
                } elseif (isset($permissionMap[$permSlug])) {
                    $permIds[] = $permissionMap[$permSlug];
                }
            }
            $role->permissions()->sync($permIds);
            $roleModels[$slug] = $role;
        }

        $users = User::all();
        foreach ($users as $user) {
            $roleSlug = $user->role ?? null;
            if ($roleSlug && isset($roleModels[$roleSlug])) {
                $user->roles()->sync([$roleModels[$roleSlug]->id]);
            }
        }

        $this->command->info('Roles & permissions seeded: ' . count($roles) . ' roles, ' . count($this->permissionDefs) . ' permissions');
    }
}
