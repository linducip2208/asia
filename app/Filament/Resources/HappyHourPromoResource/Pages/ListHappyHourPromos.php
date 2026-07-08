<?php

namespace App\Filament\Resources\HappyHourPromoResource\Pages;

use App\Filament\Resources\HappyHourPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHappyHourPromos extends ListRecords
{
    protected static string $resource = HappyHourPromoResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
