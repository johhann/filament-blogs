<?php

namespace App\Models;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $casts = [
        'id' => 'integer',
        'blog_id' => 'integer',
        'user_id' => 'integer',
    ];

    public function blog(): BelongsTo
    {
        return $this->belongsTo(Blog::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getForm(): array
    {
        return [
            Textarea::make('body')
                ->required()
                ->maxLength(65535)
                ->columnSpanFull(),
            Select::make('blog_id')
                ->relationship('blog', 'title')
                ->required(),
            Select::make('user_id')
                ->relationship('user', 'name')
                ->required(),
        ];
    }
}
