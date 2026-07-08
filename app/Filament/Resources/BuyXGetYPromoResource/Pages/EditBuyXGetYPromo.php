<?php

namespace App\Filament\Resources\BuyXGetYPromoResource\Pages;

use App\Filament\Resources\BuyXGetYPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBuyXGetYPromo extends EditRecord
{
    protected static string $resource = BuyXGetYPromoResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
