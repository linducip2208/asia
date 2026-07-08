<?php

namespace App\Filament\Resources\MemberPromoResource\Pages;

use App\Filament\Resources\MemberPromoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListMemberPromos extends ListRecords
{
    protected static string $resource = MemberPromoResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
