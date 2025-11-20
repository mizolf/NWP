<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight" style="color: var(--text-primary)">
            Radovi
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0" style="color: var(--text-primary); font-weight: 600;">Moji radovi</h4>
            <a href="{{ route('projects.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle me-1"></i> Novi rad
            </a>
        </div>

        @if($projects->isEmpty())
            <div class="alert alert-info">
                <strong>Nema radova</strong> - Trenutno nemate nijedan rad. Kreirajte novi rad kako biste započeli.
            </div>
        @else
            <div class="card">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Naziv</th>
                            <th>Voditelj</th>
                            <th>Početak</th>
                            <th>Završetak</th>
                            <th class="text-end">Akcije</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td style="font-weight: 500; color: var(--text-primary);">{{ $project->name }}</td>
                                <td style="color: var(--text-secondary);">{{ $project->leader->name ?? '—' }}</td>
                                <td style="color: var(--text-secondary);">{{ $project->start_date }}</td>
                                <td style="color: var(--text-secondary);">{{ $project->end_date }}</td>
                                <td class="text-end">
                                    <a href="{{ route('projects.show', $project) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        Pregled
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
