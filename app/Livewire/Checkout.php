<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Split;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class Checkout extends Component implements HasForms
{
    use InteractsWithForms;

    public ShippingMethod $shippingMethod;
    public $userId;
    public ?array $data = [];

    // individual properties here
    public ?string $first_name = null;
    public ?string $last_name = null;
    public ?string $phone_number = null;
    public ?string $address_line_1 = null;
    public ?string $address_line_2 = null;
    public ?string $city = null;
    public ?string $state = null;
    public ?string $country = null;
    public ?string $postal_code = null;
    public ?string $shipping_method_id = null;
    public ?string $user_id = null;
    public ?string $shipping_method_name = null;
    public ?string $shipping_method_description = null;
    public ?string $expected_delivery_time = null;
    public ?float $shipping_cost = null;
    public ?float $subtotal = null;
    public ?float $total_amount = null;
    public ?string $payment_method = null;

    public function mount()
    {
        // Get the authenticated user's ID
        $this->userId = Auth::user()->id;
        $this->shippingMethod = new ShippingMethod();
        $this->form->fill();
    }

    // wizard form here
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make()
                    ->steps([
                        // step 1
                        Step::make('customer_information')
                            ->icon('heroicon-m-user-circle')
                            ->label('Customer Information')
                            ->schema([
                                // Add your customer information fields here
                                Section::make('Personal Information')
                                    ->description('Personal Information')
                                    ->icon('heroicon-o-user')
                                    ->schema([TextInput::make('first_name')->required()->columns(), TextInput::make('last_name')->required()])
                                    ->columns(2),
                                Section::make('Contact Information')
                                    ->description('Contact Information')
                                    ->icon('heroicon-o-phone')
                                    ->schema([TextInput::make('phone_number')->tel()->required()]),
                                Section::make('Address')
                                    ->description('Address')
                                    ->icon('heroicon-o-map')
                                    ->schema([TextArea::make('address_line_1')->required(), TextArea::make('address_line_2')]),
                                Section::make('Location Details')
                                    ->description('Location Details')
                                    ->icon('heroicon-m-map-pin')
                                    ->schema([TextInput::make('city')->required(), TextInput::make('state')->required(), TextInput::make('country')->required(), TextInput::make('postal_code')->required()])
                                    ->columns(2),
                                Hidden::make('user_id')
                                    ->default($this->userId)
                                    ->disabled(true),
                            ]),
                        // step 2
                        Step::make('shipping_information')
                            ->label('Shipping Information')
                            ->icon('heroicon-o-truck')
                            ->schema([
                                Section::make('Shipping Method')
                                    ->description('Shipping Method')
                                    ->icon('heroicon-o-truck')
                                    ->schema([
                                        Select::make('shipping_method_id')
                                            // ->relationship('shippingMethod', 'name')
                                            ->label('Shipping Method')
                                            ->options(ShippingMethod::all()->pluck('shipping_method_name', 'id'))
                                            ->required()
                                            ->live()
                                            ->native(false)
                                            ->searchable()
                                            ->selectablePlaceholder(false)
                                            ->afterStateUpdated(function (Set $set, $state) {
                                                $shippingMethod = ShippingMethod::find($state);
                                                $set('shipping_method_description', $shippingMethod->shipping_method_description);
                                                $set('shipping_method_name', $shippingMethod->shipping_method_name);  // Populate the name field
                                                $set('expected_delivery_time', $shippingMethod->expected_delivery_time);  // Populate the expected delivery time field
                                                $set('shipping_cost', $shippingMethod->cost);  // Populate the cost field

                                                // set the updated total amount in the $set and round it
                                                $set('total_amount', round(Cart::where('user_id', $this->userId)->sum('total_price') + $shippingMethod->cost, 2));

                                                // set subtotal in the $set and round it

                                                $set('subtotal', round(Cart::where('user_id', $this->userId)->sum('total_price'), 2));
                                            }),
                                    ]),
                                //
                                Split::make([
                                    Section::make('Shipping Method Details')
                                        ->description('Shipping Method Details')
                                        ->icon('heroicon-o-information-circle')
                                        ->collapsible()
                                        ->schema([
                                            TextInput::make('shipping_method_name')
                                                ->label('Name')
                                                ->extraAttributes(['class' => 'font-bold'])
                                                ->readOnly(),
                                            Textarea::make('shipping_method_description')->label('Description')->readonly(),
                                            TextInput::make('expected_delivery_time')
                                                ->label('Expected Delivery Time')
                                                ->extraAttributes(['class' => 'font-bold'])
                                                ->readOnly(),
                                            TextInput::make('shipping_cost')
                                                ->label('Cost')
                                                ->extraAttributes(['class' => 'font-bold'])
                                                ->readOnly(),
                                        ]),
                                    Section::make('Cart Items')
                                        ->description('Cart Items')
                                        ->icon('heroicon-o-shopping-bag')
                                        ->schema([
                                            Section::make('')
                                                ->columns([
                                                    'default' => 3,
                                                    'xs' => 3,
                                                    'sm' => 3,
                                                    'md' => 3,
                                                    'lg' => 3,
                                                    'xl' => 3,
                                                    '2xl' => 3,
                                                ])
                                                ->schema([
                                                    Placeholder::make('')
                                                        ->content('Item')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                    Placeholder::make('')
                                                        ->content('Quantity')
                                                        ->extraAttributes(['class' => 'font-bold text-center']),
                                                    Placeholder::make('')
                                                        ->content('Price')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                ]),
                                            // new section here
                                            Section::make('')
                                                ->columns([
                                                    'default' => 3,
                                                    'xs' => 3,
                                                    'sm' => 3,
                                                    'md' => 3,
                                                    'lg' => 3,
                                                    'xl' => 3,
                                                    '2xl' => 3,
                                                ])
                                                ->schema(function () {
                                                    $cartItems = Cart::where('user_id', $this->userId)->get();
                                                    $fields = [];
                                                    foreach ($cartItems as $cartItem) {
                                                        // product name
                                                        $fields[] = Placeholder::make('')
                                                            ->content($cartItem->product->name)
                                                            ->extraAttributes(['class' => 'font-bold truncate']);

                                                        // quantity
                                                        $fields[] = Placeholder::make('')
                                                            ->content($cartItem->quantity)
                                                            ->extraAttributes(['class' => 'font-bold text-center']);

                                                        // price
                                                        $fields[] = Placeholder::make('')
                                                            ->content($cartItem->total_price)
                                                            ->extraAttributes(['class' => 'font-bold']);
                                                    }
                                                    return $fields;
                                                }),
                                            Section::make()
                                                ->schema([
                                                    // subtotal
                                                    Placeholder::make('')
                                                        ->content('Subtotal')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                    TextInput::make('subtotal')
                                                        ->label('')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                    // shipping cost
                                                    Placeholder::make('')
                                                        ->content('Shipping Cost')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                    TextInput::make('shipping_cost')
                                                        ->label('')
                                                        ->extraAttributes(['class' => 'font-bold', 'outline-none']),
                                                    // total amount
                                                    Placeholder::make('')
                                                        ->content('Total Amount')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                    TextInput::make('total_amount')
                                                        ->label('')
                                                        ->extraAttributes(['class' => 'font-bold']),
                                                ])
                                                ->columns([
                                                    'default' => 2,
                                                    'sm' => 2,
                                                    'xl' => 2,
                                                    '2xl' => 2,
                                                ]),
                                        ])
                                        ->grow(false)
                                        ->columns(2),
                                ])->from('md'),
                                //
                            ]),
                        // step 3
                        Step::make('payment_information')
                            ->label('Payment Information')
                            ->schema([
                                // Add your payment information fields here
                                // payment methods
                                //    use radio button
                                Section::make('Payment Method')
                                    ->description('Payment Method')
                                    ->icon('heroicon-o-credit-card')
                                    ->schema([
                                        Radio::make('payment_method')
                                            ->label('Payment Method')
                                            //    get name
                                            ->options(PaymentMethod::all()->pluck('pay_method_name', 'id'))
                                            ->inline()
                                            ->afterStateUpdated(function (Set $set, $state) {
                                                // dynamically change the submit button text based on the payment method
                                                if ($state == 'online') {
                                                    $set('submitAction', 'Proceed to Payment');
                                                } else {
                                                    $set('submitAction', 'Place Order');
                                                }
                                            }),
                                    ]),
                            ]),
                        // step 4
                        Step::make('Review')
                            ->label('Review')
                            ->schema([
                                // Add your confirmation fields here
                                //  all previous steps
                                Split::make([
                                    Section::make('Review')->schema([
                                        // **** For each field, make a placeholder. The contents are dynamic using the $get() utility injection ****
                                        Section::make('Personal Information')
                                            ->description('Personal Information')
                                            ->schema([Placeholder::make('First Name')->content(fn(Get $get): string => $get('first_name') ?? ''), Placeholder::make('Last Name')->content(fn(Get $get): string => $get('last_name') ?? '')])
                                            ->columns(2),
                                        Section::make('Contact Information')
                                            ->description('Contact Information')
                                            ->schema([Placeholder::make('Phone Number')->content(fn(Get $get): string => $get('phone_number') ?? '')])
                                            ->grow(false),
                                        Section::make('Address')
                                            ->description('Address')
                                            ->schema([Placeholder::make('Address Line 1')->content(fn(Get $get): string => $get('address_line_1') ?? ''), Placeholder::make('Address Line 2')->content(fn(Get $get): string => $get('address_line_2') ?? '')]),
                                        Section::make('Location Details')
                                            ->description('Location Details')
                                            ->schema([Placeholder::make('City')->content(fn(Get $get): string => $get('city') ?? ''), Placeholder::make('State')->content(fn(Get $get): string => $get('state') ?? ''), Placeholder::make('Country')->content(fn(Get $get): string => $get('country') ?? ''), Placeholder::make('Postal Code')->content(fn(Get $get): string => $get('postal_code') ?? '')])
                                            ->columns(2),
                                        Section::make('Order Details')
                                            ->description('Order Details')
                                            ->schema([Placeholder::make('Shipping Method')->content(fn(Get $get): string => ShippingMethod::find($get('shipping_method_id') ?? '')->shipping_method_name ?? ''), Placeholder::make('Payment Method')->content(fn(Get $get): string => PaymentMethod::find($get('payment_method') ?? '')->pay_method_name ?? '')])
                                            ->columns(2),
                                    ]),
                                ]),
                            ]),
                    ])
                    ->submitAction(new HtmlString(Blade::render(<<<BLADE
                            <button
                                wire:click="create"
                                class='btn btn-warning'
                            > {{ \$payment_method == '1' ? __('Proceed to Payment') : __('Place Order') }}
                            </button>
                        BLADE, ['payment_method' => $this->payment_method])))
                    ->nextAction(fn(Action $action) => $action->label('Next step')->icon('heroicon-m-chevron-right')->color('success')->button()->outlined()),
            ])
            ->model(Shipping::class);
        // ->statePath('data')
    }

    public function create()
    {
        session(['formState' => $this->form->getState()]);

        // Retrieve the form state from the session and dump it
        // dd(session('formState'));
        // return redirect(route('razorpay.test'));

        // if payment method is cash on delivery
        if ($this->form->getState()['payment_method'] == 2) {
            DB::transaction(function () {
                // create order
                // $order = Order::create($this->form->getState());
                $order = new Order();
                $order->user_id = Auth::user()->id;
                $order->total_amount = $this->form->getState()['total_amount'];
                // use user id , timestamp and order_ prefix for order number
                $order->order_number = 'order_' . Auth::user()->id . '_' . time();
                $order->status = 'pending';
                $order->payment_method = PaymentMethod::find($this->form->getState()['payment_method'])->pay_method_name;
                $order->payment_status = 'pending';

                // Retrieve the user's cart items
                $userId = Auth::user()->id;
                $cartItems = Cart::where('user_id', $userId)->get();

                // Format the cart items for storing in the orders table
                $items = $cartItems->map(function ($item) {
                    return [
                        'product_id' => $item->product_id,
                        'quantity' => $item->quantity,
                    ];
                });

                // Store the cart items as JSON in the order
                $order->items = $items->toJson();

                // Save the order
                $order->save();
                // Clear the user's cart
                Cart::where('user_id', $userId)->delete();

                // add shipping details
                $shipping = new Shipping();
                $shipping->user_id = Auth::user()->id;
                $shipping->first_name = $this->form->getState()['first_name'];
                $shipping->last_name = $this->form->getState()['last_name'];
                $shipping->shipping_method_id = $this->form->getState()['shipping_method_id'];
                $shipping->address_line_1 = $this->form->getState()['address_line_1'];
                $shipping->address_line_2 = $this->form->getState()['address_line_2'];
                $shipping->city = $this->form->getState()['city'];
                $shipping->state = $this->form->getState()['state'];
                $shipping->country = $this->form->getState()['country'];
                $shipping->postal_code = $this->form->getState()['postal_code'];
                $shipping->phone_number = $this->form->getState()['phone_number'];
                $shipping->save();

                // clear session
                session()->forget('formState');
                // Send notification
                Notification::make()
                    ->title('Order Placed Successfully')
                    ->success()
                    ->send();
            });
            $this->form->fill();
            return redirect(route('home'));
        }

        if ($this->form->getState()['payment_method'] == 1) {
            return redirect(route('razorpay.index'));
            // Shipping::create($this->form->getState());
            //      $this->form->model(Shipping::class)->saveRelationships();
            $this->form->fill();
        }
    }

    public function render()
    {
        return view('livewire.checkout');
    }
}
