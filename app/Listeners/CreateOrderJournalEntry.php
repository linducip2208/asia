<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Models\ChartOfAccount;
use App\Models\JournalEntry;
use App\Models\JournalEntryItem;
use App\Models\LoyaltyPoint;
use App\Models\CashAccount;
use Illuminate\Support\Facades\DB;

class CreateOrderJournalEntry
{
    public function handle(OrderCompleted $event): void
    {
        $order = $event->order;
        $tenantId = $order->tenant_id;

        $coaPenjualan = ChartOfAccount::where('tenant_id', $tenantId)->where('code', '4-1100')->first();
        $coaHPP = ChartOfAccount::where('tenant_id', $tenantId)->where('code', '5-1000')->first();
        $coaPersediaan = ChartOfAccount::where('tenant_id', $tenantId)->where('code', '1-1400')->first();

        $cashPayments = $order->payments()->whereHas('paymentMethod', fn($q) => $q->where('type', 'cash'))->sum('amount');
        $otherPayments = $order->total_amount - $cashPayments;

        if ($cashPayments > 0) {
            $coaKas = ChartOfAccount::where('tenant_id', $tenantId)->where('code', '1-1100')->first();
            if ($coaKas && $coaPenjualan) {
                $journal = JournalEntry::create([
                    'journal_number' => 'JR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
                    'tenant_id' => $tenantId,
                    'outlet_id' => $order->outlet_id,
                    'user_id' => $order->user_id,
                    'journal_date' => now()->toDateString(),
                    'reference_type' => 'sales',
                    'reference_id' => $order->id,
                    'description' => 'Penjualan tunai — ' . $order->order_number,
                    'status' => 'posted',
                    'total_debit' => $cashPayments,
                    'total_credit' => $cashPayments,
                    'posted_at' => now(),
                ]);

                JournalEntryItem::create(['journal_entry_id' => $journal->id, 'chart_of_account_id' => $coaKas->id, 'debit' => $cashPayments, 'credit' => 0, 'description' => 'Kas dari penjualan']);
                JournalEntryItem::create(['journal_entry_id' => $journal->id, 'chart_of_account_id' => $coaPenjualan->id, 'debit' => 0, 'credit' => $cashPayments, 'description' => 'Pendapatan penjualan']);
            }
        }

        if ($coaHPP && $coaPersediaan) {
            $totalCost = $order->items()->sum(DB::raw('quantity * (SELECT cost_price FROM products WHERE products.id = order_items.product_id)'));
            if ($totalCost > 0) {
                $journal = JournalEntry::create([
                    'journal_number' => 'JR-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6)),
                    'tenant_id' => $tenantId,
                    'outlet_id' => $order->outlet_id,
                    'user_id' => $order->user_id,
                    'journal_date' => now()->toDateString(),
                    'reference_type' => 'hpp',
                    'reference_id' => $order->id,
                    'description' => 'HPP penjualan — ' . $order->order_number,
                    'status' => 'posted',
                    'total_debit' => $totalCost,
                    'total_credit' => $totalCost,
                    'posted_at' => now(),
                ]);
                JournalEntryItem::create(['journal_entry_id' => $journal->id, 'chart_of_account_id' => $coaHPP->id, 'debit' => $totalCost, 'credit' => 0, 'description' => 'Harga Pokok Penjualan']);
                JournalEntryItem::create(['journal_entry_id' => $journal->id, 'chart_of_account_id' => $coaPersediaan->id, 'debit' => 0, 'credit' => $totalCost, 'description' => 'Persediaan keluar']);
            }
        }
    }
}
