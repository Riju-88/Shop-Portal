<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Forms\Components\BelongsToManyMultiSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;

class EditProduct extends EditRecord
{
    protected static string $resource = ProductResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')->required()->columnSpan(2),
            RichEditor::make('description')->columnSpan(2),
            TextInput::make('brand')->columnSpan(2),
            TextInput::make('price')->required()->numeric()->columnSpan(2),
            FileUpload::make('image')->image()->multiple()->imageEditor()->directory('product-images'),
            Select::make('categories')
                ->searchable()
                ->multiple()
                ->relationship(titleAttribute: 'name')
                ->preload()
                ->required()
                ->columnSpan(2),
            TextInput::make('quantity')->type('number')->required(),
            ToggleButtons::make('is_featured')
                ->label('Product is Featured?')
                ->boolean()
                ->grouped(),
            Repeater::make('attributes')
                ->relationship('attributes')
                ->addActionLabel('+ Add New Attribute')
                ->schema([
                    TextInput::make('name')->required(),
                    TextInput::make('value')->required(),
                ])
                ->defaultItems(0)
                ->columnSpan(2),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Product updated';
    }
}
