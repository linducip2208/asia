<?php

namespace App\Filament\Resources\MemberPromoResource\Pages;

use App\Filament\Resources\MemberPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMemberPromo extends EditRecord
{
    protected static string $resource = MemberPromoResource::class;
    protected function getHeaderActions(): array { return [Actions\DeleteAction::make()]; }
}
