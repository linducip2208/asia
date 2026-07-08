<?php

namespace App\Listeners;

use App\Events\OrderCompleted;
use App\Models\LoyaltyPoint;
use App\Models\StockMovement;

class UpdateLoyaltyAndStock
{
    public function handle(OrderCompleted $event): void
    {
        $order = $event->order;

        if ($order->customer_id) {
            $pointsPerAmount = 1000;
            $pointsEarned = (int) ($order->total_amount / $pointsPerAmount);

            if ($pointsEarned > 0) {
                $currentBalance = LoyaltyPoint::where('customer_id', $order->customer_id)
                    ->latest('id')->value('balance') ?? 0;

                LoyaltyPoint::create([
                    'customer_id' => $order->customer_id,
                    'order_id' => $order->id,
                    'points_earned' => $pointsEarned,
                    'points_redeemed' => 0,
                    'balance' => $currentBalance + $pointsEarned,
                    'description' => 'Poin dari pembelanjaan #' . $order->order_number,
                ]);

                $order->customer->increment('total_points', $pointsEarned);
                $order->customer->increment('total_spent', $order->total_amount);
            }
        }

        foreach ($order->items as $item) {
            if ($item->product) {
                $item->product->decrement('current_stock', $item->quantity);

                StockMovement::create([
                    'product_id' => $item->product_id,
                    'outlet_id' => $order->outlet_id,
                    'type' => 'out',
                    'quantity' => $item->quantity,
                    'reference_type' => 'order',
                    'reference_id' => $order->id,
                    'notes' => 'Penjualan #' . $order->order_number,
                ]);
            }
        }
    }
}
