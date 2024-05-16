<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Forms\Components\BelongsToSelect;
use Illuminate\Support\Str;
use Filament\Forms\Set;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

 

    public function form(Form $form): Form
    {
        return $form->schema([

          
            TextInput::make('name')
            ->required()
            ->live(onBlur: true)
            ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state)))->columnSpan(2),
            RichEditor::make('description')->columnSpan(2),
            BelongsToSelect::make('parent_id')
            ->relationship('parent', 'name'),
            TextInput::make('slug')
        ]);
    }

 


}
