<?php

namespace App\Filament\Resources\BatchNumberResource\Pages;

use App\Filament\Resources\BatchNumberResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBatchNumbers extends ListRecords
{
    protected static string $resource = BatchNumberResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
