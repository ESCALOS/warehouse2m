<div>
    <form wire:submit='create'>
        {{ $this->form }}

        <button class="float-right p-2 px-4 m-4 text-center text-white bg-indigo-800 rounded-lg hover:bg-indigo-700" type="submit">
            <span wire:loading>
                <x-filament::loading-indicator wire:loading class="w-5 h-5" /> Cargando
            </span>
            <span wire:loading.remove>Enviar</span>
        </button>
    </form>

    <x-filament-actions::modals />
</div>
