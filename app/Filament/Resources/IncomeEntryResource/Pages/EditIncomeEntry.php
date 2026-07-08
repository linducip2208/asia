<?php

namespace App\Filament\Resources\IncomeEntryResource\Pages;

use App\Filament\Resources\IncomeEntryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncomeEntry extends EditRecord
{
    protected static string $resource = IncomeEntryResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
