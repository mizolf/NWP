<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary)">
            Uredi rad
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">
                            {{ auth()->id() === $project->leader_id ? 'Uredi sve podatke' : 'Ažuriraj obavljene zadatke' }}
                        </h5>

                        <form method="POST" action="{{ route('projects.update', $project) }}">
                            @csrf
                            @method('PUT')

                            @if (auth()->id() === $project->leader_id)
    {{-- voditelj: SVA polja --}}
    <div class="mb-3">
        <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Naziv rada</label>
        <input type="text" name="name"
               value="{{ old('name', $project->name) }}"
               class="form-control @error('name') is-invalid @enderror"
               required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>

        <div class="mb-3">
            <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Opis</label>
            <textarea name="description"
                    class="form-control @error('description') is-invalid @enderror"
                    rows="3">{{ old('description', $project->description) }}</textarea>
            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Cijena (€)</label>
            <input type="number" step="0.01" name="price"
                value="{{ old('price', $project->price) }}"
                class="form-control @error('price') is-invalid @enderror"
                required>
            @error('price') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Obavljeni zadaci</label>
            <textarea name="tasks_done"
                    class="form-control @error('tasks_done') is-invalid @enderror"
                    rows="3">{{ old('tasks_done', $project->tasks_done) }}</textarea>
            @error('tasks_done') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Datum početka</label>
                <input type="date" name="start_date"
                    value="{{ old('start_date', $project->start_date) }}"
                    class="form-control @error('start_date') is-invalid @enderror"
                    required>
                @error('start_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Datum završetka</label>
                <input type="date" name="end_date"
                    value="{{ old('end_date', $project->end_date) }}"
                    class="form-control @error('end_date') is-invalid @enderror">
                @error('end_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    @else
        {{-- član tima: samo tasks_done --}}
        <div class="mb-3">
            <label class="form-label" style="font-weight: 500; color: var(--text-primary);">Obavljeni zadaci</label>
            <textarea name="tasks_done"
                    class="form-control @error('tasks_done') is-invalid @enderror"
                    rows="3"
                    placeholder="Dodajte nove obavljene zadatke...">{{ old('tasks_done', $project->tasks_done) }}</textarea>
            @error('tasks_done') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>
    @endif


                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('projects.show', $project) }}"
                                   class="btn btn-outline-secondary">
                                    Odustani
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    Spremi promjene
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
