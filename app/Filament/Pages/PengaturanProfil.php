<?php

namespace App\Filament\Pages;

use App\Models\SystemSetting;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use UnitEnum;

class PengaturanProfil extends Page
{
    use WithFileUploads;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-building-office-2';
    protected static string|UnitEnum|null $navigationGroup = '⚙️ Pengaturan';
    protected static ?string $navigationLabel = 'Profil Perusahaan';
    protected static ?int $navigationSort = 5;
    protected string $view = 'filament.pages.pengaturan.profil';

    public $company_name = '';
    public $address = '';
    public $phone = '';
    public $email = '';
    public $website = '';
    public $npwp = '';
    public $footer_text = '';
    public $logo = null;
    public $current_logo = null;

    public function mount(): void
    {
        $this->company_name = SystemSetting::getValue('company_name', '');
        $this->address = SystemSetting::getValue('company_address', '');
        $this->phone = SystemSetting::getValue('company_phone', '');
        $this->email = SystemSetting::getValue('company_email', '');
        $this->website = SystemSetting::getValue('company_website', '');
        $this->npwp = SystemSetting::getValue('company_npwp', '');
        $this->footer_text = SystemSetting::getValue('invoice_footer_text', '');
        $this->current_logo = SystemSetting::getValue('company_logo');
    }

    public function deleteLogo(): void
    {
        $oldLogo = SystemSetting::getValue('company_logo');
        if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
            Storage::disk('public')->delete($oldLogo);
        }
        SystemSetting::setValue('company_logo', '');
        $this->current_logo = null;

        Notification::make()
            ->title('Logo berhasil dihapus!')
            ->success()
            ->send();
    }

    public function save(): void
    {
        if ($this->logo) {
            $this->validate(['logo' => 'image|mimes:png,jpg,jpeg,gif,svg|max:2048']);

            $oldLogo = SystemSetting::getValue('company_logo');
            if ($oldLogo && Storage::disk('public')->exists($oldLogo)) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $this->logo->store('company', 'public');
            SystemSetting::setValue('company_logo', $path);
        }

        SystemSetting::setValue('company_name', (string) $this->company_name);
        SystemSetting::setValue('company_address', (string) $this->address);
        SystemSetting::setValue('company_phone', (string) $this->phone);
        SystemSetting::setValue('company_email', (string) $this->email);
        SystemSetting::setValue('company_website', (string) $this->website);
        SystemSetting::setValue('company_npwp', (string) $this->npwp);
        SystemSetting::setValue('invoice_footer_text', (string) $this->footer_text);

        Notification::make()
            ->title('Profil perusahaan berhasil disimpan!')
            ->success()
            ->send();
    }
}
