<?php

namespace App\Filament\Resources\CashTransferResource\Pages;

use App\Filament\Resources\CashTransferResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCashTransfer extends CreateRecord
{
    protected static string $resource = CashTransferResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['transfer_number'] = 'TRF-'.date('Ymd').'-'.strtoupper(substr(uniqid(), -6));
        $data['user_id'] = auth()->id();

        return $data;
    }
}
