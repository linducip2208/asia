<?php

namespace App\Filament\Resources\GiftVoucherResource\Pages;

use App\Filament\Resources\GiftVoucherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateGiftVoucher extends CreateRecord
{
    protected static string $resource = GiftVoucherResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['code'] = 'VCR-'.strtoupper(substr(uniqid(), -8));

        return $data;
    }
}
