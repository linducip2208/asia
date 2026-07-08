<?php

namespace App\Filament\Resources\GiftVoucherBatchResource\Pages;

use App\Filament\Resources\GiftVoucherBatchResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGiftVoucherBatch extends EditRecord
{
    protected static string $resource = GiftVoucherBatchResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
