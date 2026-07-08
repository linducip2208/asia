<?php

namespace App\Filament\Resources\TaxConfigurationResource\Pages;

use App\Filament\Resources\TaxConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTaxConfiguration extends EditRecord
{
    protected static string $resource = TaxConfigurationResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
