<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary)">
            Rad: {{ $project->name }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-body p-4">
                        <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">Detalji rada</h5>

                        <dl class="row mb-0">
                            <dt class="col-sm-4" style="color: var(--text-secondary); font-weight: 500;">Opis</dt>
                            <dd class="col-sm-8" style="color: var(--text-primary);">{{ $project->description ?: '—' }}</dd>

                            <dt class="col-sm-4" style="color: var(--text-secondary); font-weight: 500;">Cijena</dt>
                            <dd class="col-sm-8" style="color: var(--text-primary);">{{ $project->price }} €</dd>

                            <dt class="col-sm-4" style="color: var(--text-secondary); font-weight: 500;">Obavljeni zadaci</dt>
                            <dd class="col-sm-8" style="color: var(--text-primary);">{{ $project->tasks_done ?: 'Nema zabilježenih zadataka' }}</dd>

                            <dt class="col-sm-4" style="color: var(--text-secondary); font-weight: 500;">Datum početka</dt>
                            <dd class="col-sm-8" style="color: var(--text-primary);">{{ $project->start_date }}</dd>

                            <dt class="col-sm-4" style="color: var(--text-secondary); font-weight: 500;">Datum završetka</dt>
                            <dd class="col-sm-8" style="color: var(--text-primary);">{{ $project->end_date ?: 'Nije određen' }}</dd>
                        </dl>
                    </div>
                </div>

                    <div class="card mb-3">
            <div class="card-body p-4">
                <h5 class="mb-4" style="color: var(--text-primary); font-weight: 600;">Članovi tima</h5>

                <ul class="list-group mb-3">
                    @forelse ($project->members as $member)
                        <li class="list-group-item d-flex justify-content-between align-items-center" style="border-color: var(--border-color);">
                            <span style="color: var(--text-primary);">{{ $member->name }} <small style="color: var(--text-secondary);">({{ $member->email }})</small></span>
                        </li>
                    @empty
                        <li class="list-group-item" style="border-color: var(--border-color); color: var(--text-secondary);">Nema članova tima.</li>
                    @endforelse
                </ul>

                @if (auth()->id() === $project->leader_id)
                    <form method="POST"
                        action="{{ route('projects.members.add', $project) }}"
                        class="row g-2">
                        @csrf
                        <div class="col-md-8">
                            <select name="user_id" class="form-select" required>
                                <option value="">-- Odaberi korisnika --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 d-grid">
                            <button type="submit" class="btn btn-primary">
                                Dodaj člana
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('projects.index') }}"
                       class="btn btn-outline-secondary">
                        Natrag na popis
                    </a>
                @if (auth()->id() === $project->leader_id || $project->members->contains(auth()->id()))
                    <a href="{{ route('projects.edit', $project) }}" class="btn btn-outline-primary">
                        Uredi
                    </a>
                @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
