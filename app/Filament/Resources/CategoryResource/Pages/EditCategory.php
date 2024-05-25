<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Pages\Page;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Str;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    public function form(Form $form): Form
    {
        return $form->schema([
            // ...
            Section::make('Category Details')
                ->description('Category name and description')
                ->icon('heroicon-o-information-circle')
                ->schema([
                    TextInput::make('name')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                    RichEditor::make('description'),
                ]),
            Section::make('Category Image')
                ->description('Category image')
                ->icon('heroicon-o-shopping-bag')
                ->schema([
                    FileUpload::make('image')->image()->imageEditor()->directory('category-images'),
                ]),
            Section::make('Other Details')
                ->schema([
                    BelongsToSelect::make('parent_id')
                        ->relationship('parent', 'name'),
                    TextInput::make('slug')
                ])
                ->columns(2),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
