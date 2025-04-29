<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StationResource\Pages;
use App\Filament\Resources\StationResource\RelationManagers;
use App\Models\Station;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StationResource extends Resource
{
    protected static ?string $model = Station::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->required(),
                Textarea::make('description')->nullable(),
                FileUpload::make('image')->directory('stations'),
                TextInput::make('src')->required(),
                Select::make('status')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Not Active',
                    ])
                    ->required(),
                Select::make('country_id')->relationship('country', 'country')->required(),
                Select::make('city_id')->relationship('city', 'city')->required(),
                Select::make('language_id')->relationship('language', 'language')->required(),
                Select::make('tags')
                    ->multiple()
                    ->relationship('tags', 'tag')
                    ->preload(),
                TextInput::make('type')->required(),
            ]);
    }

    public static function table(Table $table): Table
{
    return $table
        ->columns([
            TextColumn::make('name')->label('Station Name')->sortable(),
            TextColumn::make('country.country')->label('Country')->sortable(),
            TextColumn::make('city.city')->label('City')->sortable(),
            TextColumn::make('language.language')->label('Language')->sortable(),
            TextColumn::make('type')->label('Type')->sortable(),
            ToggleColumn::make('status')
                ->label('Status')
                ->onColor('success')
                ->offColor('danger')
                ->sortable()
                ->afterStateUpdated(function ($record, $state) {
                    $record->update([
                        'status' => $state ? 1 : 0,
                    ]);
                }),
        ])
        ->filters([
            SelectFilter::make('status')
                ->label('Status')
                ->options([
                    1 => 'Active',
                    0 => 'Inactive',
                ]),
        ])
        ->actions([
            Tables\Actions\ActionGroup::make([
                Tables\Actions\EditAction::make()
                    ->slideOver(),
                Tables\Actions\DeleteAction::make(),
            ]),
        ])
        // ->bulkActions([
        //     Tables\Actions\BulkActionGroup::make([
        //         Tables\Actions\DeleteBulkAction::make(),
        //     ]),
        // ])
        ;
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
            'index' => Pages\ListStations::route('/'),
            'create' => Pages\CreateStation::route('/create'),
            'edit' => Pages\EditStation::route('/{record}/edit'),
        ];
    }
}
