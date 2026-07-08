<?php

namespace App\Filament\Resources\BatchNumberResource\Pages;

use App\Filament\Resources\BatchNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBatchNumber extends EditRecord
{
    protected static string $resource = BatchNumberResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
