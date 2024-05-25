<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;
use Filament\Tables\Columns\ImageColumn;

class ListProducts extends ListRecords
{
    protected static string $resource = ProductResource::class;

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                
                TextColumn::make('description')->limit(50)
                ->formatStateUsing(function($state) {
                return new HtmlString($state);
                }),
                TextColumn::make('price'),
                ImageColumn::make('image')->defaultImageUrl(url('/images/placeholder.png')),
                TextColumn::make('brand'),
                TextColumn::make('quantity'),
                TextColumn::make('is_featured'),

            ]);
    }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
