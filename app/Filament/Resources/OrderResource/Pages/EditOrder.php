<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use App\Models\User;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions;
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
                    'processing' => 'Processing',
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
                        }),
                ])
                ->columns(2),
            // display order item details
            Section::make('Order Items')
                ->schema(function ($record) {
                    $items = json_decode($record->items, true);

                    if (is_array($items)) {
                        $components = collect($items)
                            ->flatMap(function ($item) use (&$totalAmount) {
                                $product = Product::with('categories')->find($item['product_id']);

                                // Calculate the total price without discounts
                                $totalPrice = $product->price * $item['quantity'];

                                // Calculate the discount
                                $itemDiscount = 0;
                                foreach ($product->categories as $category) {
                                    $itemDiscount += ($totalPrice * ($category->discount / 100));
                                }

                                // Apply the discount and round the final price
                                $finalPrice = round($totalPrice - $itemDiscount, 2);

                                // Accumulate the final price to the total amount
                                $totalAmount += $finalPrice;

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
                                            Placeholder::make('price')
                                                ->label('Price')
                                                ->content($finalPrice)
                                                ->columnStart(2),
                                            Placeholder::make('Description')
                                                ->content(new HtmlString($product->description))
                                                ->columnSpan(2),
                                            Placeholder::make('Image')
                                                ->extraAttributes(['class' => 'flex justify-center gap-2'])
                                                ->columnSpan(2)
                                                ->content(function () use ($product): HtmlString {
                                                    $imageTags = '';

                                                    if (is_array($product->image)) {
                                                        foreach ($product->image as $imagePath) {
                                                            if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
                                                                $imageSrc = $imagePath;
                                                            } else {
                                                                $imageSrc = asset('storage/' . $imagePath);
                                                            }
                                                            $imageTags .= "<div>
                                                 <img src='" . $imageSrc . "' class='w-32 object-contain rounded-lg'>
                                                            </div>";
                                                        }
                                                    } else {
                                                        $imageTags = '<p>No images available.</p>';
                                                    }

                                                    return new HtmlString($imageTags);
                                                }),
                                        ]),
                                ];
                            })
                            ->toArray();  // Convert the collection to an array

                        // Fetch and add the shipping cost
                        $shipping = Shipping::find($record->shipping_id);
                        $shippingMethod = $shipping ? ShippingMethod::find($shipping->shipping_method_id) : null;
                        $shippingCost = $shippingMethod ? $shippingMethod->cost : 0;

                        // Accumulate the shipping cost to the total amount
                        $totalAmount += $shippingCost;

                        // Add shipping cost and total amount placeholders
                        $components[] = Section::make('')
                            ->schema([
                                Placeholder::make('shipping_method')
                                    ->label('Shipping Method')
                                    ->content($shippingMethod->shipping_method_name)
                                    ->columnStart(1),
                                Placeholder::make('shipping_cost')
                                    ->label('Shipping Cost')
                                    ->content(round($shippingCost, 2))
                                    ->columnStart(2),
                                Placeholder::make('total_amount_with_shipping')
                                    ->label('Estimated Total Amount')
                                    ->content(round($totalAmount, 2))
                                    ->columnStart(1),
                                Placeholder::make('total_amount_order')
                                    ->label('Total Amount of Order')
                                    ->content($record->total_amount)
                                    ->columnStart(2),
                            ]);

                        // Add shipping details if available
                        if ($shipping) {
                            $components[] = Section::make('Shipping Details')
                                ->schema([
                                    Placeholder::make('user_id')
                                        ->label('User ID')
                                        ->content($shipping->user_id)
                                        ->columnStart(1),
                                    Placeholder::make('')
                                        ->label('Email')
                                        ->content(User::find($shipping->user_id)->email)
                                        ->columnStart(2),
                                    Placeholder::make('phone_number')
                                        ->label('Phone Number')
                                        ->content($shipping->phone_number)
                                        ->columnStart(3),
                                    Placeholder::make('first_name')
                                        ->label('First Name')
                                        ->content($shipping->first_name)
                                        ->columnStart(1),
                                    Placeholder::make('last_name')
                                        ->label('Last Name')
                                        ->content($shipping->last_name)
                                        ->columnStart(2),
                                    Placeholder::make('address_line_1')
                                        ->label('Address Line 1')
                                        ->content($shipping->address_line_1)
                                        ->columnStart(1),
                                    Placeholder::make('address_line_2')
                                        ->label('Address Line 2')
                                        ->content($shipping->address_line_2)
                                        ->columnStart(1),
                                    Placeholder::make('city')
                                        ->label('City')
                                        ->content($shipping->city)
                                        ->columnStart(1),
                                    Placeholder::make('state')
                                        ->label('State')
                                        ->content($shipping->state)
                                        ->columnStart(2),
                                    Placeholder::make('postal_code')
                                        ->label('Postal Code')
                                        ->content($shipping->postal_code)
                                        ->columnStart(1),
                                    Placeholder::make('country')
                                        ->label('Country')
                                        ->content($shipping->country)
                                        ->columnStart(2),
                                ]);
                        }

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
