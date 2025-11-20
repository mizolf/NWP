<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary)">
            Kontrolna ploča
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm" style="border-radius: 0.75rem; border: 1px solid var(--border-color);">
                <div class="p-6">
                    <h4 class="mb-3" style="color: var(--text-primary); font-weight: 600;">
                        Dobrodošli natrag! 👋
                    </h4>
                    <p class="mb-4" style="color: var(--text-secondary);">
                        Uspješno ste prijavljeni u sustav. Upravljajte svojim radovima i pratite napredak.
                    </p>

                    <a href="{{ route('projects.index') }}" class="btn btn-primary">
                        Pregledaj radove
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
