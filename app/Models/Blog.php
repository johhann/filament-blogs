<?php

namespace App\Models;

use App\Enums\BlogStatus;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Blog extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $casts = [
        'id' => 'integer',
        'published_at' => 'timestamp',
        'category_id' => 'integer',
        'author_id' => 'integer',
        'tags' => 'array',
        'status' => BlogStatus::class,
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function publish()
    {
        $this->status = BlogStatus::PUBLISHED;
        $this->save();
    }

    public function reject()
    {
        $this->status = BlogStatus::REJECTED;
        $this->save();
    }

    public static function getForm(): array
    {
        return [
            Section::make('Blog Details')
                ->columns(2)
                ->icon('heroicon-o-information-circle')
                ->description('This section consists main blog attributes')
                ->collapsible()
                ->schema([
                    TextInput::make('title')
                        ->required()
                        ->columnSpanFull()
                        ->helperText('Here you should write blog title')
                        ->maxLength(255),
                    MarkdownEditor::make('body')
                        ->required()
                        ->columnSpanFull(),
                    SpatieMediaLibraryFileUpload::make('images')
                        ->image()
                        ->multiple()
                        ->imageEditor()
                        ->reorderable()
                        ->directory('blogs')
                        ->columnSpanFull(),
                    CheckboxList::make('tags')
                        ->required()
                        ->columnSpanFull()
                        ->columns(3)
                        ->searchable()
                        ->bulkToggleable(true)
                        ->options([
                            'tech' => 'Tech',
                            'health' => 'Health',
                            'social' => 'Social',
                            'family' => 'Family',
                            'sport' => 'Sport',
                            'religion' => 'Religion',
                            'styles' => 'Styles',
                            'houses' => 'Houses',
                        ]),
                    Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->createOptionForm(Category::getForm())
                        ->editOptionForm(Category::getForm()),
                    Select::make('author_id')
                        ->relationship('author', 'name')
                        ->searchable()
                        ->preload()
                        ->required()
                        ->createOptionForm(Author::getForm())
                        ->editOptionForm(Author::getForm()),
                    Fieldset::make('Status and Published at')
                        ->columns(2)
                        ->schema([
                            Select::make('status')
                                ->required()
                                ->enum(BlogStatus::class)
                                ->options(BlogStatus::class),
                            DatePicker::make('published_at')
                                ->native(false),
                        ]),
                ]),

        ];
    }
}
