<?php

namespace App\Filament\Resources;

use App\Enums\BlogStatus;
use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    protected static ?string $model = Blog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(Blog::getForm());
    }

    public static function table(Table $table): Table
    {
        return $table
            ->persistFiltersInSession()
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->description(function (Blog $record) {
                        return Str::of($record->body)->limit(40);
                    }),
                SpatieMediaLibraryImageColumn::make('author.avatar')
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        return 'https://ui-avatars.com/api/?background=0D8ABC&color=fff&name='.urlencode($record->author->name);
                    }),
                Tables\Columns\TextColumn::make('author.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(function ($state) {
                        return $state->getColor();
                    })
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('author')
                    ->relationship('author', 'name')
                    ->preload()
                    ->multiple()
                    ->searchable(),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('publish')
                        ->action(function ($record) {
                            return $record->publish();
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->visible(function ($record) {
                            return $record->status !== BlogStatus::PUBLISHED;
                        })
                        ->after(function () {
                            Notification::make()
                                ->success()
                                ->title('Blog has been approved')
                                ->body('This specific blog has been approved')
                                ->send();
                        }),
                    Tables\Actions\Action::make('reject')
                        ->action(function ($record) {
                            return $record->publish();
                        })
                        ->requiresConfirmation()
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->visible(function ($record) {
                            return $record->status !== BlogStatus::REJECTED;
                        })
                        ->after(function () {
                            Notification::make()
                                ->danger()
                                ->title('Blog has been rejected')
                                ->body('This specific blog has been rejected')
                                ->send();
                        }),
                ]),

            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve')
                        ->action(function (Collection $records) {
                            $records->each->publish();
                        })
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->after(function () {
                            Notification::make()
                                ->success()
                                ->title('Blogs with bulk selection has been published')
                                ->send();
                        }),
                    Tables\Actions\BulkAction::make('reject')
                        ->action(function (Collection $records) {
                            $records->each->reject();
                        })
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->after(function () {
                            Notification::make()
                                ->danger()
                                ->title('Blogs with bulk selection has been rejected')
                                ->send();
                        }),
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
