<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
// use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Actions;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->columnSpan(2),
            RichEditor::make('description')->columnSpan(2),
            TextInput::make('brand')->columnSpan(2),
            TextInput::make('price')->required()->numeric()->columnSpan(2),
            FileUpload::make('image')->image()->multiple()->imageEditor()->directory('product-images')->columnSpan(2),
            Select::make('categories')
                ->searchable()
                ->multiple()
                ->relationship(titleAttribute: 'name')
                ->preload()
                ->required()
                ->columnSpan(2),
            // BelongsToManyMultiSelect::make('categories')
            //     ->relationship('categories', 'name')  // Adjust relationship name to 'categories'
            //     ->required()
            //     ->columnSpan(2),
            TextInput::make('quantity')->type('number')->required(),
            ToggleButtons::make('is_featured')
                ->required()
                ->label('Product is Featured?')
                ->boolean()
                ->default(false)
                ->grouped(),
            Repeater::make('attributes')
                ->relationship('attributes')
                ->addActionLabel('+ Add New Attribute')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('value')->required(),
                ])
                ->defaultItems(0)
                ->collapsible()
                ->columnSpan(2),
        ]);
    }
}
