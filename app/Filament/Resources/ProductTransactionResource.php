<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductTransactionResource\Pages;
use App\Filament\Resources\ProductTransactionResource\RelationManagers;
use App\Models\ProductTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Models\Shoe;
use App\Models\PromoCode;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Wizard\Step;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Filters\SelectFilter;
use Filament\Notifications\Notification;


class ProductTransactionResource extends Resource
{
    protected static ?string $model = ProductTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                Forms\components\Wizard::make([
                    Forms\components\Wizard\Step::make('Product and Price')
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('shoe_id')
                                    ->relationship('shoe', 'name')
                                    ->required()
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $shoe = Shoe::find($state);
                                        $price = $shoe ? $shoe->price : 0;
                                        $quantity = $get('quantity') ?? 1;
                                        $subTotalAmount = $price * $quantity;

                                        $set('price', $price);
                                        $set('sub_total_amount', $subTotalAmount);

                                        $discount = $get('discount_amount') ?? 0;
                                        $grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);

                                        $size = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                        $set('shoe_sizes', $size);
                                    })
                                    ->afterStateHydrated(function (callable $get, callable $set, $state){
                                        $shoeId = $state;
                                        if($shoeId){
                                            $shoe = Shoe::find($shoeId);
                                            $sizes = $shoe ? $shoe->sizes->pluck('size', 'id')->toArray() : [];
                                            $set('shoe_sizes', $sizes);
                                        }
                                    }),

                                Forms\Components\Select::make('shoe_size')
                                    ->Label('Shoe Size')
                                    ->options(function (callable $get){
                                        $sizes = $get('shoe_sizes');
                                        return is_array($sizes) ? $sizes : [];
                                    })
                                    ->required()
                                    ->live(),
                                
                                Forms\Components\TextInput::make('quantity')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Qty')
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $price = $get('price');
                                        $quantity = $state;
                                        $subTotalAmount = $price * $quantity;

                                        $set('sub_total_amount', $subTotalAmount);

                                        $discount = $get('discount_amount') ?? 0;
                                        $grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);
                                    }),

                                Forms\Components\Select::make('promo_code_id')
                                    ->relationship('promoCode', 'code')
                                    ->searchable()
                                    ->preload()
                                    ->live()
                                    ->afterStateUpdated(function ($state, callable $get, callable $set){
                                        $subTotalAmount = $get('sub_total_amount');
                                        $promoCode = PromoCode::find($state);
                                        $discount = $promoCode ? $promoCode->discount_amount : 0;

                                        $set('discount_amount', $discount);

                                        $grandTotalAmount = $subTotalAmount - $discount;
                                        $set('grand_total_amount', $grandTotalAmount);
                                    }),
                                
                                Forms\Components\TextInput::make('sub_total_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('grand_total_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR')
                                    ->readOnly(),

                                Forms\Components\TextInput::make('discount_amount')
                                    ->required()
                                    ->numeric()
                                    ->prefix('IDR'),
                            ]),
                        ]),
                    Forms\components\Wizard\Step::make('Customer Information')
                        ->schema([
                            Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('phone')
                                    ->required()
                                    ->tel()
                                    ->maxLength(20),

                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('city')
                                    ->required()
                                    ->maxLength(255),

                                Forms\Components\TextInput::make('post_code')
                                    ->required()
                                    ->maxLength(20)
                                    ->label('Post Code'),

                                Forms\Components\TextArea::make('address')
                                    ->rows(5)
                                    ->maxLength(255),
                            ]),
                        ]),

                        Forms\components\Wizard\Step::make('Payment Information')
                        ->schema([
                            Forms\Components\TextInput::make('booking_trx_id')
                                ->required()
                                ->maxLength(255),
                                
                            ToggleButtons::make('is_paid')
                                ->label('Apakah Sudah membayar?')
                                ->required()
                                ->boolean()
                                ->grouped()
                                ->icons([
                                    true => 'heroicon-o-pencil',
                                    false => 'heroicon-o-clock',
                                ]),
                            
                            Forms\Components\FileUpload::make('proof')
                                ->image()
                                ->required(),
                        ]),
                ])
                ->columnSpan('full')
                ->columns(1)
                ->skippable()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\ImageColumn::make('shoe.thumbnail'),

                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('booking_trx_id')
                    ->searchable(),
                
                Tables\Columns\IconColumn::make('is_paid')
                    ->boolean()
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->label('Terverifikasi'),
            ])
            ->filters([
                //
                SelectFilter::make('shoe_id')
                    ->label('Shoe')
                    ->relationship('shoe', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),

                Tables\Actions\Action::make('approve')
                ->label('Approve')
                ->action(function (ProductTransaction $record){
                    $record->is_paid = true;
                    $record->save();

                    // Trigger the custom notification
                    Notification::make()
                        ->title('Order Approved')
                        ->success()
                        ->body('The order has been successfully.')
                        ->send();
                })
                ->color('success')
                ->requiresConfirmation()
                ->visible(fn (ProductTransaction $record) => !$record->is_paid)
                
               
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductTransactions::route('/'),
            'create' => Pages\CreateProductTransaction::route('/create'),
            'edit' => Pages\EditProductTransaction::route('/{record}/edit'),
        ];
    }
}
