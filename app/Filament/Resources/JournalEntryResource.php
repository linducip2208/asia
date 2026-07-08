<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalEntryResource\Pages;
use App\Models\JournalEntry;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class JournalEntryResource extends Resource
{
    protected static ?string $model = JournalEntry::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-document-duplicate';
    protected static string|\UnitEnum|null $navigationGroup = '💳 Keuangan';
    protected static ?string $navigationLabel = 'Jurnal Umum';
    protected static ?int $navigationSort = 30;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            \Filament\Schemas\Components\Section::make('Informasi Jurnal')->schema([
                \Filament\Schemas\Components\TextInput::make('journal_number')->label('No. Jurnal')->disabled()->default(fn() => 'JR-'.date('Ymd').'-'.strtoupper(substr(uniqid(),-6))),
                \Filament\Schemas\Components\DatePicker::make('journal_date')->label('Tanggal Jurnal'),
                \Filament\Schemas\Components\TextInput::make('reference_type')->label('Tipe Referensi')->maxLength(255),
                \Filament\Schemas\Components\TextInput::make('description')->label('Deskripsi')->maxLength(255),
                \Filament\Schemas\Components\Textarea::make('notes')->label('Catatan')->rows(3),
                \Filament\Schemas\Components\Select::make('status')->label('Status')->options([
                    'draft' => 'Draft','posted' => 'Posted',
                ])->default('draft'),
            ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('journal_number')->label('No.')->searchable(),
            Tables\Columns\TextColumn::make('journal_date')->label('Tanggal')->date('d M Y'),
            Tables\Columns\TextColumn::make('description')->label('Deskripsi')->searchable(),
            Tables\Columns\TextColumn::make('total_debit')->label('Debit')->money('IDR'),
            Tables\Columns\TextColumn::make('total_credit')->label('Kredit')->money('IDR'),
            Tables\Columns\TextColumn::make('status')->label('Status')->badge()->colors([
                'gray' => 'draft','success' => 'posted',
            ]),
        ])->filters([Tables\Filters\SelectFilter::make('status')])
          ->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getRelations(): array { return []; }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJournalEntries::route('/'),
            'create' => Pages\CreateJournalEntry::route('/create'),
            'edit' => Pages\EditJournalEntry::route('/{record}/edit'),
        ];
    }
}
