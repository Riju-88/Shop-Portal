<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\ProductReview;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\StaticAction;
use Filament\Forms\Actions\Submit;
use Filament\Forms\Components\BelongsToSelect;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;
use Mokhosh\FilamentRating\Components\Rating;

class Review extends Component implements HasForms, HasActions
{
    use InteractsWithActions;
    use InteractsWithForms;

    public Product $product;
    public ProductReview $productReviewModel;
    public $productId;
    public $userId;
    public ?ProductReview $editing = null;
    public ?array $data = [];

    //     public ?string $rating = null;

    // public ?string $review = null;
    // public ?string $title = null;
    // public ?array $image = null;
    public function mount($productId): void
    {
        $this->productId = $productId;
        if (Auth()->check()) {
            $this->userId = Auth()->user()->id;
        } else {
            $this->userId = null;
        }
        $this->form->fill();
    }

    // public function mount(Product $product)
    // {
    //     $this->product = $product;
    // }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Review')
                    ->description('List of reviews')
                    ->schema([
                        Rating::make('rating')->required(),
                        FileUpload::make('image')
                            ->multiple()
                            ->directory('reviews')
                            ->visibility('public'),
                        TextInput::make('title')->required(),
                        RichEditor::make('review')->required(),
                        Hidden::make('product_id')->default($this->productId),
                        Hidden::make('user_id')->default($this->userId),
                    ])
            ])
            ->model(ProductReview::class)
            ->statePath('data');
    }
    // #[On('create')]
    // public function create(): void
    // {
    //     $productreview = ProductReview::create($this->form->getState());
    //     \Log::info($this->form->getState());
    //     // dd($this->form->getState());
    //     // Save the relationships from the form to the post after it is created.
    //     $this->form->model($productreview)->saveRelationships();
    //     $this->form->fill();
    // }

    public function create()
    {
        if ($this->editing) {
            $this->editing->update($this->form->getState());
            $this->editing = null;
            $this->form->fill();
        } else {
            ProductReview::create($this->form->getState());
            $this->form->model(ProductReview::class)->saveRelationships();
            $this->form->fill();
        }
    }

    public function edit(ProductReview $review)
    {
        $this->editing = $review;
        $this->form->fill($review->toArray());
    }

    public function openEditModal(ProductReview $review)
    {
        $this->productreview = $review;
        $this->form->fill();
        $this->emit('openModal', 'edit-review-modal');
    }

    //    not in use
    // public function xxxdelete(ProductReview $review)
    // {
    //     $review->delete();
    //     $this->form->fill();
    //     Notification::make()
    //         ->title('Review Deleted')
    //         ->success()
    //         ->send();
    // }

    public function delete(): Action
    {
        return Action::make('delete')
            ->modalHeading('Delete Review')
            ->action(function (array $arguments) {
                $review = ProductReview::find($arguments['review_id']);

                $review?->delete();
                Notification::make()
                    ->title('Review Deleted')
                    ->success()
                    ->send();
            })
            ->requiresConfirmation()
            ->modalIcon('heroicon-o-trash')
            ->modalSubmitActionLabel('Delete')
            ->color('danger')
            ->button()
            ->extraAttributes(['class' => 'btn '])
            ->outlined()
            ->modalIconColor('danger')
            ->modalSubmitAction(fn(StaticAction $action) => $action
                ->button()
                ->outlined());
    }

    public function render()
    {
        $reviews = ProductReview::all();
        return view('livewire.review', compact('reviews'));
    }
}
