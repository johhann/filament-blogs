<?php

namespace App\Models;

use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
    ];

    public function blogs(): HasMany
    {
        return $this->hasMany(Blog::class);
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
            MarkdownEditor::make('title')
                ->required()
                ->maxLength(255),
        ];
    }
}
