<?php

namespace App\Filament\Resources\IncomeEntryResource\Pages;

use App\Filament\Resources\IncomeEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListIncomeEntries extends ListRecords
{
    protected static string $resource = IncomeEntryResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
