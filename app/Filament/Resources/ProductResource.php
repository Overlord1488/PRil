<?php

namespace App\Filament\Resources;

use App\Enums\ProductType;
use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-shopping-bag';

    protected static string|\UnitEnum|null $navigationGroup = 'Каталог';

    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Название')
                ->required()
                ->maxLength(200)
                ->live(onBlur: true)
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                ->columnSpan(2),

            TextInput::make('slug')
                ->label('Slug')
                ->required()
                ->maxLength(200)
                ->unique(ignoreRecord: true),

            Select::make('type')
                ->label('Тип')
                ->options(collect(ProductType::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()]))
                ->required()
                ->live(),

            Select::make('category_id')
                ->label('Категория')
                ->relationship('category', 'name')
                ->searchable()
                ->nullable(),

            TextInput::make('price')
                ->label('Цена (₽)')
                ->numeric()
                ->required()
                ->minValue(0),

            TextInput::make('stock_qty')
                ->label('Остаток')
                ->numeric()
                ->nullable()
                ->visible(fn ($get) => $get('type') === ProductType::Physical->value),

            TextInput::make('weight_kg')
                ->label('Вес (кг)')
                ->numeric()
                ->nullable()
                ->visible(fn ($get) => $get('type') === ProductType::Physical->value),

            Textarea::make('description')
                ->label('Краткое описание')
                ->rows(3)
                ->columnSpanFull(),

            RichEditor::make('body')
                ->label('Полное описание')
                ->columnSpanFull(),

            FileUpload::make('cover_path')
                ->label('Обложка')
                ->image()
                ->directory('products/covers')
                ->columnSpanFull(),

            Repeater::make('images')
                ->label('Галерея')
                ->relationship()
                ->schema([
                    FileUpload::make('path')->label('Изображение')->image()->directory('products/gallery')->required(),
                    TextInput::make('alt')->label('Alt-текст')->maxLength(200),
                    TextInput::make('sort_order')->label('Порядок')->numeric()->default(0),
                ])
                ->columnSpanFull()
                ->collapsed(),

            Repeater::make('files')
                ->label('Файлы для скачивания')
                ->relationship()
                ->schema([
                    TextInput::make('label')->label('Название файла')->required()->maxLength(120),
                    FileUpload::make('path')->label('Файл')->required()->disk('private')->directory('product-files'),
                    TextInput::make('sort_order')->label('Порядок')->numeric()->default(0),
                ])
                ->columnSpanFull()
                ->collapsed()
                ->visible(fn ($get) => in_array($get('type'), [ProductType::Digital->value, ProductType::Program->value])),

            Toggle::make('is_published')->label('Опубликован')->default(false),
            Toggle::make('in_stock')->label('В наличии')->default(true),

            TextInput::make('sort_order')->label('Порядок сортировки')->numeric()->default(0),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Название')->searchable()->sortable()->limit(40),
                TextColumn::make('type')->label('Тип')->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof ProductType ? $state->label() : $state),
                TextColumn::make('category.name')->label('Категория')->default('—'),
                TextColumn::make('price')->label('Цена')->money('RUB')->sortable(),
                IconColumn::make('is_published')->label('Опубл.')->boolean(),
                IconColumn::make('in_stock')->label('В наличии')->boolean(),
                TextColumn::make('updated_at')->label('Обновлён')->dateTime('d.m.Y')->sortable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Тип')
                    ->options(collect(ProductType::cases())->mapWithKeys(fn ($c) => [$c->value => $c->label()])),
                TernaryFilter::make('is_published')->label('Опубликован'),
                TernaryFilter::make('in_stock')->label('В наличии'),
            ])
            ->actions([EditAction::make()])
            ->bulkActions([BulkActionGroup::make([DeleteBulkAction::make()])]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
