<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Product;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
use Illuminate\Support\Arr;
use Illuminate\Support\HtmlString;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    // change title
    protected static ?string $title = 'Update Order Status';

    // change breadcrumb
    protected static ?string $breadcrumb = 'Manage';

    public function form(Form $form): Form
    {
        return $form->schema([
            //
            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'delivered' => 'Delivered',
                    'cancelled' => 'Cancelled',
                ])
                ->default('pending')
                ->native(false)
                ->required(),
            //    display payment method and payment status
            Section::make('Payment')
                ->schema([
                    Placeholder::make('payment_method')
                        ->label('Payment Method')
                        ->content(function ($record) {
                            return $record->payment_method;
                        }),
                    Placeholder::make('payment_status')
                        ->label('Payment Status')
                        ->content(function ($record) {
                            return $record->payment_status;
                        })
                ])
                ->columns(2),
            // display order item details
            Section::make('Order Items')
                ->schema(function ($record) {
                    $items = json_decode($record->items, true);

                    if (is_array($items)) {
                        $components = collect($items)
                            ->flatMap(function ($item) {
                                $product = Product::find($item['product_id']);

                                return [
                                    Section::make('')
                                        ->schema([
                                            Placeholder::make('product_name')
                                                ->label('Product Name')
                                                ->content($product->name)
                                                ->columnStart(1),
                                            Placeholder::make('product_quantity')
                                                ->label('Quantity')
                                                ->content($item['quantity'])
                                                ->columnStart(2),
                                            Placeholder::make('product_description')
                                                ->label('Product Description')
                                                ->content($product->description)
                                                ->columnSpan(2),
                                            Placeholder::make('Image')
                                                ->extraAttributes(['class' => 'flex justify-center gap-2'])
                                                ->columnSpan(2)
                                                ->content(function () use ($product): HtmlString {
                                                    $imageTags = '';

                                                    if (is_array($product->image)) {
                                                        foreach ($product->image as $imagePath) {
                                                            $imageTags .= "<div >
                                                            <img src='" . $imagePath . "' class='w-32 object-cover rounded-lg'></div>";
                                                        }
                                                    } else {
                                                        $imageTags = '<p>No images available.</p>';
                                                    }

                                                    return new HtmlString($imageTags);
                                                })
                                        ])
                                ];
                            })
                            ->toArray();  // Convert the collection to an array

                        return $components;  // Return the array of components
                    } else {
                        return ['No items found.'];  // Return an array with the message
                    }
                })
                ->collapsible(),
        ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
