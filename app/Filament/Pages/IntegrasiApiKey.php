<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;
use UnitEnum;

class IntegrasiApiKey extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-key';
    protected static string|UnitEnum|null $navigationGroup = '🔗 Integrasi';
    protected static ?string $navigationLabel = 'API Key';
    protected static ?int $navigationSort = 50;
    protected string $view = 'filament.pages.integrasi.api-key';

    public $tokenName = '';
    public $generatedToken = '';

    public function generateToken(): void
    {
        $this->validate(['tokenName' => 'required|string|max:255']);

        $token = auth()->user()->createToken($this->tokenName);
        $this->generatedToken = $token->plainTextToken;

        $this->tokenName = '';

        Notification::make()
            ->title('API Key berhasil dibuat!')
            ->body('Salin token sekarang — tidak akan ditampilkan lagi.')
            ->success()
            ->send();
    }

    public function revokeToken($id): void
    {
        $token = PersonalAccessToken::findOrFail($id);

        if ($token->tokenable_id === auth()->id()) {
            $token->delete();

            Notification::make()
                ->title('API Key berhasil di-revoke!')
                ->success()
                ->send();
        }
    }
}
