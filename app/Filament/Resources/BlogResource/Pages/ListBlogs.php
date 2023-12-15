<?php

namespace App\Filament\Resources\BlogResource\Pages;

use App\Enums\BlogStatus;
use App\Filament\Resources\BlogResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListBlogs extends ListRecords
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All Blogs'),
            'submitted' => Tab::make('Submitted')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', BlogStatus::SUBMITTED);
                }),
            'published' => Tab::make('Published')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', BlogStatus::PUBLISHED);
                }),
            'rejected' => Tab::make('Rejected')
                ->modifyQueryUsing(function ($query) {
                    return $query->where('status', BlogStatus::REJECTED);
                }),
        ];
    }
}
