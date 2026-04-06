<?php

namespace App\Filament\Resources\TrainerResource\Pages;

use App\Filament\Resources\TrainerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditTrainer extends EditRecord
{
    protected static string $resource = TrainerResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }
}
