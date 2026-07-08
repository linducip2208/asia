<?php

namespace App\Filament\Resources\BuyXGetYPromoResource\Pages;

use App\Filament\Resources\BuyXGetYPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBuyXGetYPromos extends ListRecords
{
    protected static string $resource = BuyXGetYPromoResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
