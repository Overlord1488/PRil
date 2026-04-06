<?php

namespace App\Filament\Resources\TrainingDirectionResource\Pages;

use App\Filament\Resources\TrainingDirectionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainingDirection extends EditRecord
{
    protected static string $resource = TrainingDirectionResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
