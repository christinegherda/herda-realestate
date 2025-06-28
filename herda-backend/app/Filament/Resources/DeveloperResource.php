<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DeveloperResource\Pages;
use App\Filament\Resources\DeveloperResource\RelationManagers;
use App\Models\Developer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;

class DeveloperResource extends Resource
{
    protected static ?string $model = Developer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->maxLength(255),
                TextInput::make('broker_coordinator_name')
                    ->maxLength(255),
                TextInput::make('broker_coordinator_fb')
                    ->maxLength(255),
                TextInput::make('contact_number')
                    ->maxLength(255),
                Textarea::make('description')
                    ->maxLength(65535),
                FileUpload::make('logo')
                    ->label('Developer Logo')
                    ->image()
                    ->directory('developer-logos')
                    ->maxSize(1024),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                TextColumn::make('id'),
                ImageColumn::make('logo')->label('Logo'),
                TextColumn::make('name'),
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
            'index' => Pages\ListDevelopers::route('/'),
            'create' => Pages\CreateDeveloper::route('/create'),
            'edit' => Pages\EditDeveloper::route('/{record}/edit'),
        ];
    }
}
