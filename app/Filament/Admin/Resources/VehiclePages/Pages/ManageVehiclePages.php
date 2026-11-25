<?php

namespace App\Filament\Admin\Resources\VehiclePages\Pages;

use App\Filament\Admin\Resources\VehiclePages\VehiclePageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageVehiclePages extends ManageRecords
{
    protected static string $resource = VehiclePageResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Pagină nouă')];
    }
}
