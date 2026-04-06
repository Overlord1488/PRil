<?php

namespace App\Filament\Resources\TrainingDirectionResource\Pages;

use App\Filament\Resources\TrainingDirectionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListTrainingDirections extends ListRecords
{
    protected static string $resource = TrainingDirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()];
    }
}
