<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Group;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\ViewField;
use App\Forms\Components\AddressInput;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(2)->schema([
                TextInput::make('name')->required()->maxLength(255),
                TextInput::make('slug')->required()->unique(ignoreRecord: true),

                Select::make('agent_id')
                    ->relationship('agent', 'name')
                    ->label('Agent')
                    ->required(),

                TextInput::make('price')->required()->numeric(),

                Select::make('property_type')
                    ->options([
                        'Residential' => 'Residential',
                        'Commercial' => 'Commercial',
                        'Condo' => 'Condo',
                        'Lot Only' => 'Lot Only',
                    ])
                    ->label('Property Type'),

                Select::make('status')
                    ->options([
                        'For Sale' => 'For Sale',
                        'For Rent' => 'For Rent',
                        'Sold' => 'Sold',
                    ])
                    ->default('For Sale'),

                TextInput::make('location')->nullable(),
                TextInput::make('city')->nullable()
                            ->label('City/Province'),
            ]),

            Grid::make(2)->schema([
                TextInput::make('bedrooms')->numeric()->nullable(),
                TextInput::make('bathrooms')->numeric()->nullable(),
                TextInput::make('floor_area')->numeric()->nullable()->label('Floor Area (sqm)'),
                TextInput::make('lot_area')->numeric()->nullable()->label('Lot Area (sqm)'),
            ]),

            Grid::make(2)->schema([
                TextInput::make('latitude')->nullable(),
                TextInput::make('longitude')->nullable(),
            ]),


            Grid::make(2)->schema([
                TextInput::make('developer')->label('Developer / Owner / Seller'),

                Select::make('model_type')
                    ->options([
                        'Single Attached' => 'Single Attached',
                        'Single Detached' => 'Single Detached',
                        'Townhouse' => 'Townhouse',
                        'Rowhouse' => 'Rowhouse',
                        'Studio' => 'Studio',
                        'One Bedroom' => 'One Bedroom',
                        'Two Bedrooms' => 'Two Bedrooms',
                        'Three Bedrooms' => 'Three Bedrooms',
                        'Penthouse' => 'Penthouse',
                    ])
                    ->label('Model Type'),
            ]),

            TextInput::make('gdrive_link')
                ->label('Google Drive Link')
                ->url()
                ->suffixIcon('heroicon-o-link')
                ->columnSpanFull(),

            Grid::make(1)->schema([
                // Textarea::make('description')->rows(5)->nullable(),

                RichEditor::make('description')
                ->label('Description')
                ->columnSpanFull()
                ->toolbarButtons([
                    'bold',
                    'italic',
                    'strike',
                    'link',
                    'blockquote',
                    'codeBlock',
                    'h2',
                    'h3',
                    'bulletList',
                    'orderedList',
                    'redo',
                    'undo',
                ]),
            ]),

            FileUpload::make('thumbnail')
                ->image()
                ->label('Main Thumbnail')
                ->directory('properties/thumbnails')
                ->nullable(),

            FileUpload::make('gallery')
                ->image()
                ->multiple()
                ->reorderable()
                ->label('Gallery Images')
                ->directory('properties/gallery')
                ->nullable(),

                FileUpload::make('lot_plan')
                    ->label('Lot Plan')
                    ->directory('documents/lot-plans')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->preserveFilenames()
                    ->downloadable(),

                FileUpload::make('title_document')
                    ->label('Title Document')
                    ->directory('documents/title')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->preserveFilenames()
                    ->downloadable(),

                FileUpload::make('tax_declaration')
                    ->label('Tax Declaration')
                    ->directory('documents/tax')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->preserveFilenames()
                    ->downloadable(),

                FileUpload::make('atn_ats')
                    ->label('ATN / ATS')
                    ->directory('documents/atn')
                    ->acceptedFileTypes(['application/pdf', 'image/*'])
                    ->preserveFilenames()
                    ->downloadable(),

            Toggle::make('featured')->label('Mark as Featured'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id'),
                TextColumn::make('name'),
                TextColumn::make('slug'),
                TextColumn::make('location'),
                TextColumn::make('agent.name'),
                TextColumn::make('property_type'),
                TextColumn::make('status'),
                TextColumn::make('featured'),
                TextColumn::make('city'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
