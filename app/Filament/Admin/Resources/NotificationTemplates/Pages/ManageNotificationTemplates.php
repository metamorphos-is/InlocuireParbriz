<?php

namespace App\Filament\Admin\Resources\NotificationTemplates\Pages;

use App\Filament\Admin\Resources\NotificationTemplates\NotificationTemplateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageNotificationTemplates extends ManageRecords
{
    protected static string $resource = NotificationTemplateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Șablon nou'),
        ];
    }
}
