<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Column;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    public function table(Table $table): Table
        {
            return $table
                ->columns([
                    TextColumn::make('name'),
                    TextColumn::make('slug'),
                    TextColumn::make('description')
                    ->formatStateUsing(function($state) {
                    return new HtmlString($state);
                    }),
                    TextColumn::make('parent_id'),

                ]);
        }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
