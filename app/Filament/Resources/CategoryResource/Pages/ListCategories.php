<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions;
use Illuminate\Support\HtmlString;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')->defaultImageUrl(url('/images/placeholder.png')),
                TextColumn::make('name')
                    ->sortable(),
                TextColumn::make('slug'),
                TextColumn::make('description')
                    ->limit(50)
                    ->formatStateUsing(function ($state) {
                        return new HtmlString($state);
                    }),
                TextColumn::make('discount')
                    ->sortable(),
                TextColumn::make('parent_id'),
                TextColumn::make('created_at')
                    ->sortable()
            ])
            ->defaultSort('created_at', 'desc');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
