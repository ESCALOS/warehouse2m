<?php

namespace App\Livewire;

use App\Models\Movement;
use App\Models\Warehouse;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Tabs;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class ViewOutput extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Warehouse $warehouse;
    public Movement $movement;
    public Movement $output;

    public function mount(): void {
        $this->output = Movement::withTrashed()->find($this->movement->id);
    }

    public function outputInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->output)
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('generalData')
                            ->label('Datos Generales')
                            ->schema([
                                TextEntry::make('employeeMovement.employee.name')
                                    ->label('Empleado'),
                                TextEntry::make('employeeMovement.costCenter.description')
                                    ->label('Centro de costo'),
                                TextEntry::make('movementReason.description')
                                    ->label('Razón de movimiento'),
                                TextEntry::make('observations')
                                    ->label('Observaciones')
                                    ->html()
                            ])
                            ->icon('heroicon-m-user'),
                        Tabs\Tab::make('itemsList')
                            ->label('Detalle')
                            ->icon('heroicon-m-cube')
                            ->schema([
                                RepeatableEntry::make('movementDetails')
                                    ->label('Artículos')
                                    ->schema([
                                        TextEntry::make('itemWarehouse.item.description')
                                            ->label('Descripción'),
                                        TextEntry::make('quantity')
                                            ->label('Cantidad')
                                    ])
                                    ->columns(2)
                                    ->grid(2)
                            ])
                    ])
            ]);
    }


    public function render()
    {
        return view('livewire.view-output');
    }
}
