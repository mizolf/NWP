<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row g-4">
                <!-- Voditelj Projekti -->
                <div class="col-12 col-lg-6">
                    <div class="card mb-4">
                        <div class="card-body p-4">
                            <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">
                                <i class="bi bi-star-fill me-2" style="color: var(--primary-color);"></i>Radovi gdje sam voditelj
                            </h5>
                            <ul class="list-group">
                                @forelse ($ownedProjects as $project)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="border-color: var(--border-color);">
                                        <span style="font-weight: 500; color: var(--text-primary);">{{ $project->name }}</span>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                            Otvori
                                        </a>
                                    </li>
                                @empty
                                    <li class="list-group-item" style="border-color: var(--border-color); color: var(--text-secondary);">
                                        Niste još kreirali nijedan rad.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Član Tima Projekti -->
                <div class="col-12 col-lg-6">
                    <div class="card">
                        <div class="card-body p-4">
                            <h5 class="mb-3" style="color: var(--text-primary); font-weight: 600;">
                                <i class="bi bi-people-fill me-2" style="color: var(--secondary-color);"></i>Radovi gdje sam član tima
                            </h5>
                            <ul class="list-group">
                                @forelse ($memberProjects as $project)
                                    <li class="list-group-item d-flex justify-content-between align-items-center" style="border-color: var(--border-color);">
                                        <span style="font-weight: 500; color: var(--text-primary);">{{ $project->name }}</span>
                                        <a href="{{ route('projects.show', $project) }}" class="btn btn-sm btn-outline-primary">
                                            Otvori
                                        </a>
                                    </li>
                                @empty
                                    <li class="list-group-item" style="border-color: var(--border-color); color: var(--text-secondary);">
                                        Niste član nijednog rada.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
