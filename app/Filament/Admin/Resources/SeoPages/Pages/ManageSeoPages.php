<?php

namespace App\Filament\Admin\Resources\SeoPages\Pages;

use App\Filament\Admin\Resources\SeoPages\SeoPageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSeoPages extends ManageRecords
{
    protected static string $resource = SeoPageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Pagină SEO nouă'),
        ];
    }
}
