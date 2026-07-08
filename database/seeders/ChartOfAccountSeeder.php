<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use Illuminate\Database\Seeder;

class ChartOfAccountSeeder extends Seeder
{
    public function run(): void
    {
        $tenantId = \App\Models\Tenant::first()?->id;

        $accounts = [
            // ASET (1-0000)
            ['code' => '1-0000', 'name' => 'ASET', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 1],
            ['code' => '1-1000', 'name' => 'Aset Lancar', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 2, 'parent_code' => '1-0000'],
            ['code' => '1-1100', 'name' => 'Kas Utama', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-1000'],
            ['code' => '1-1200', 'name' => 'Bank BCA', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-1000'],
            ['code' => '1-1300', 'name' => 'Piutang Usaha (AR)', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-1000'],
            ['code' => '1-1400', 'name' => 'Persediaan Barang', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-1000'],
            ['code' => '1-1500', 'name' => 'Perlengkapan', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-1000'],
            ['code' => '1-2000', 'name' => 'Aset Tetap', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 2, 'parent_code' => '1-0000'],
            ['code' => '1-2100', 'name' => 'Peralatan', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-2000'],
            ['code' => '1-2200', 'name' => 'Kendaraan', 'type' => 'asset', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '1-2000'],

            // KEWAJIBAN (2-0000)
            ['code' => '2-0000', 'name' => 'KEWAJIBAN', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 1],
            ['code' => '2-1000', 'name' => 'Kewajiban Jangka Pendek', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '2-0000'],
            ['code' => '2-1100', 'name' => 'Hutang Usaha (AP)', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 3, 'parent_code' => '2-1000'],
            ['code' => '2-1200', 'name' => 'Hutang Pajak (PPN)', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 3, 'parent_code' => '2-1000'],
            ['code' => '2-1300', 'name' => 'Hutang Gaji', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 3, 'parent_code' => '2-1000'],
            ['code' => '2-2000', 'name' => 'Kewajiban Jangka Panjang', 'type' => 'liability', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '2-0000'],

            // EKUITAS (3-0000)
            ['code' => '3-0000', 'name' => 'EKUITAS', 'type' => 'equity', 'normal_balance' => 'credit', 'level' => 1],
            ['code' => '3-1000', 'name' => 'Modal Disetor', 'type' => 'equity', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '3-0000'],
            ['code' => '3-2000', 'name' => 'Laba Ditahan', 'type' => 'equity', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '3-0000'],
            ['code' => '3-3000', 'name' => 'Laba Tahun Berjalan', 'type' => 'equity', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '3-0000'],

            // PENDAPATAN (4-0000)
            ['code' => '4-0000', 'name' => 'PENDAPATAN', 'type' => 'revenue', 'normal_balance' => 'credit', 'level' => 1],
            ['code' => '4-1000', 'name' => 'Penjualan', 'type' => 'revenue', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '4-0000'],
            ['code' => '4-1100', 'name' => 'Penjualan Produk', 'type' => 'revenue', 'normal_balance' => 'credit', 'level' => 3, 'parent_code' => '4-1000'],
            ['code' => '4-1200', 'name' => 'Diskon Penjualan', 'type' => 'revenue', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '4-1000'],
            ['code' => '4-2000', 'name' => 'Pendapatan Lain-lain', 'type' => 'revenue', 'normal_balance' => 'credit', 'level' => 2, 'parent_code' => '4-0000'],

            // BEBAN (5-0000)
            ['code' => '5-0000', 'name' => 'BEBAN', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 1],
            ['code' => '5-1000', 'name' => 'Harga Pokok Penjualan (HPP)', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 2, 'parent_code' => '5-0000'],
            ['code' => '5-2000', 'name' => 'Beban Operasional', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 2, 'parent_code' => '5-0000'],
            ['code' => '5-2100', 'name' => 'Beban Gaji', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '5-2000'],
            ['code' => '5-2200', 'name' => 'Beban Sewa', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '5-2000'],
            ['code' => '5-2300', 'name' => 'Beban Listrik & Air', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '5-2000'],
            ['code' => '5-2400', 'name' => 'Beban Marketing', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 3, 'parent_code' => '5-2000'],
            ['code' => '5-3000', 'name' => 'Beban Lain-lain', 'type' => 'expense', 'normal_balance' => 'debit', 'level' => 2, 'parent_code' => '5-0000'],
        ];

        $created = new \SplObjectStorage;

        foreach ($accounts as $account) {
            $parentId = null;
            if (isset($account['parent_code'])) {
                $parent = ChartOfAccount::where('code', $account['parent_code'])->where('tenant_id', $tenantId)->first();
                if ($parent) {
                    $parentId = $parent->id;
                }
            }

            ChartOfAccount::create([
                'tenant_id' => $tenantId,
                'parent_id' => $parentId,
                'code' => $account['code'],
                'name' => $account['name'],
                'type' => $account['type'],
                'normal_balance' => $account['normal_balance'],
                'level' => $account['level'],
                'is_system' => true,
                'is_active' => true,
            ]);
        }

        $this->command->info('Chart of Accounts seeded: ' . count($accounts) . ' accounts');
    }
}
