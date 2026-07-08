<?php

namespace App\Filament\Resources\ExpenseEntryResource\Pages;

use App\Filament\Resources\ExpenseEntryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateExpenseEntry extends CreateRecord
{
    protected static string $resource = ExpenseEntryResource::class;
}
