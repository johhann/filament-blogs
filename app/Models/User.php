<?php

namespace App\Models;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory;

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'id' => 'integer',
        'status' => 'boolean',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
    }

    public static function getForm(): array
    {
        return [
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->required()
                ->maxLength(255),
            TextInput::make('password')
                ->password()
                ->required()
                ->maxLength(255),
            Toggle::make('status')
                ->required(),
        ];
    }
}
