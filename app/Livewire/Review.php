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

    // mount function will be called when the component is loaded.
    public function mount($productId): void
    {
        // set the product id
        $this->productId = $productId;
        // set the user id if the user is authenticated
        if (Auth()->check()) {
            $this->userId = Auth()->user()->id;
        } else {
            // if the user is not authenticated set the user id to null
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

    // create function will be called when the create button is clicked
    public function create()
    {
        // if the editing property is not null, it means we are editing an existing review
        if ($this->editing) {
            // update the review
            $this->editing->update($this->form->getState());
            // reset the editing property
            $this->editing = null;
            $this->form->fill();
        } else {
            // create a new review
            ProductReview::create($this->form->getState());
            $this->form->model(ProductReview::class)->saveRelationships();
            $this->form->fill();
        }
    }

    // edit function will be called when the edit button is clicked
    public function edit(ProductReview $review)
    {
        // set the editing property to the review that we want to edit
        $this->editing = $review;
        // fill the form with the review data
        $this->form->fill($review->toArray());
    }

    // openEditModal function will be called when the edit button is clicked
    public function openEditModal(ProductReview $review)
    {
        // set the editing property to the review that we want to edit
        $this->productreview = $review;
        $this->form->fill();
        $this->emit('openModal', 'edit-review-modal');
    }

    // delete function will be called when the delete button is clicked
    public function delete(): Action
    {
        // return a delete action
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
        // get all reviews
        $reviews = ProductReview::all();
        return view('livewire.review', compact('reviews'));
    }
}
