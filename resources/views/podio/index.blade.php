@extends('layouts.app')

@section('title', 'MQ Podio - Sistema de Premios al Desempeño')

@section('content')
<div class="hero-section">
    <div class="container py-4">
        {{-- Header --}}
        <div class="text-center mb-4 animate__animated animate__fadeInDown">
            <h1 class="display-4 fw-bold text-white mb-2">
                <i class="fa-solid fa-award me-2"></i>Podio de Honor
            </h1>
            <p class="lead text-white-50">Reconocemos el esfuerzo y dedicación de nuestros mejores empleados</p>
        </div>

        {{-- Podios generales (todas las áreas visibles) --}}
        <div class="podio-progress-wrap" id="podioProgressWrap" aria-hidden="true">
            <div class="podio-progress">
                <span class="podio-progress-bar" id="podioProgressBar"></span>
            </div>
        </div>

        <div class="podios-grid">
            @foreach($areas as $index => $area)
                @php
                    $top3 = array_slice($area['empleados'], 0, 3);
                @endphp
                <section class="podio-area-card" style="--area-color: {{ $area['color'] }}">
                    <div class="text-center mb-4">
                        <span class="area-badge" style="background: {{ $area['color'] }}">
                            <i class="fa-solid {{ $area['icono'] }} me-2"></i>{{ $area['nombre'] }}
                        </span>
                    </div>

                    <div class="podio-container">
                        <div class="podio-wrapper">
                            {{-- Puesto 2 - Plata (Izquierda) --}}
                            <div class="podio-item podio-plata">
                                <div class="avatar-card avatar-card-silver" data-tilt>
                                    <div class="avatar-card-inner">
                                        <div class="avatar-3d-wrap">
                                            <i class="fa-solid fa-user avatar-3d-icon"></i>
                                        </div>
                                        <div class="avatar-card-shine"></div>
                                        <div class="avatar-card-badge badge-silver">
                                            <i class="fa-solid fa-medal"></i> 2
                                        </div>
                                    </div>
                                    <div class="avatar-card-shadow"></div>
                                </div>
                                <h5 class="podio-name">{{ $top3[1]['nombre'] }}</h5>
                                <div class="podio-points">
                                    <i class="fa-solid fa-star"></i>
                                    <span class="points-counter" data-target="{{ $top3[1]['puntos'] }}">0</span> pts
                                </div>
                                <div class="podio-medal-label silver-label">
                                    <i class="fa-solid fa-medal"></i> Plata
                                </div>
                                <div class="podio-pedestal pedestal-silver">
                                    <span class="pedestal-number">2</span>
                                </div>
                            </div>

                            {{-- Puesto 1 - Oro (Centro) --}}
                            <div class="podio-item podio-oro">
                                <div class="crown-icon animate__animated animate__swing animate__infinite animate__slow">
                                    <i class="fa-solid fa-crown"></i>
                                </div>
                                <div class="avatar-card avatar-card-gold" data-tilt>
                                    <div class="avatar-card-inner">
                                        <div class="avatar-3d-wrap avatar-3d-wrap-gold">
                                            <i class="fa-solid fa-user avatar-3d-icon"></i>
                                        </div>
                                        <div class="avatar-card-shine"></div>
                                        <div class="avatar-card-badge badge-gold">
                                            <i class="fa-solid fa-trophy"></i> 1
                                        </div>
                                    </div>
                                    <div class="avatar-card-shadow"></div>
                                </div>
                                <h5 class="podio-name podio-name-gold">{{ $top3[0]['nombre'] }}</h5>
                                <div class="podio-points">
                                    <i class="fa-solid fa-star"></i>
                                    <span class="points-counter" data-target="{{ $top3[0]['puntos'] }}">0</span> pts
                                </div>
                                <div class="podio-medal-label gold-label">
                                    <i class="fa-solid fa-trophy"></i> Oro
                                </div>
                                <div class="podio-pedestal pedestal-gold">
                                    <span class="pedestal-number">1</span>
                                </div>
                            </div>

                            {{-- Puesto 3 - Bronce (Derecha) --}}
                            <div class="podio-item podio-bronce">
                                <div class="avatar-card avatar-card-bronze" data-tilt>
                                    <div class="avatar-card-inner">
                                        <div class="avatar-3d-wrap">
                                            <i class="fa-solid fa-user avatar-3d-icon"></i>
                                        </div>
                                        <div class="avatar-card-shine"></div>
                                        <div class="avatar-card-badge badge-bronze">
                                            <i class="fa-solid fa-medal"></i> 3
                                        </div>
                                    </div>
                                    <div class="avatar-card-shadow"></div>
                                </div>
                                <h5 class="podio-name">{{ $top3[2]['nombre'] }}</h5>
                                <div class="podio-points">
                                    <i class="fa-solid fa-star"></i>
                                    <span class="points-counter" data-target="{{ $top3[2]['puntos'] }}">0</span> pts
                                </div>
                                <div class="podio-medal-label bronze-label">
                                    <i class="fa-solid fa-medal"></i> Bronce
                                </div>
                                <div class="podio-pedestal pedestal-bronze">
                                    <span class="pedestal-number">3</span>
                                </div>
                            </div>
                        </div>

                        {{-- Confetti particles --}}
                        <div class="confetti-container">
                            @for($p = 0; $p < 30; $p++)
                                <div class="confetti-piece" style="--delay: {{ rand(0,30) / 10 }}s; --x: {{ rand(-50,50) }}px; --color: {{ ['#FFD700','#C0C0C0','#CD7F32','#6366f1','#06b6d4','#f59e0b','#ec4899'][rand(0,6)] }}"></div>
                            @endfor
                        </div>
                    </div>
                </section>
            @endforeach
        </div>

        <div class="podio-carousel-controls" id="podioCarouselControls" aria-label="Navegacion de podios">
            <button type="button" class="podio-nav-btn" data-podio-nav="prev" aria-label="Podio anterior">
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <div class="podio-dots" role="tablist" aria-label="Seleccion de podio">
                @foreach($areas as $index => $area)
                    <button
                        type="button"
                        class="podio-dot {{ $index === 0 ? 'is-active' : '' }}"
                        data-podio-index="{{ $index }}"
                        aria-label="Ir a {{ $area['nombre'] }}"
                        title="{{ $area['nombre'] }}"
                    ></button>
                @endforeach
            </div>
            <button type="button" class="podio-nav-btn" data-podio-nav="next" aria-label="Podio siguiente">
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>

        {{-- Tabs de Áreas --}}
        <ul class="nav nav-pills justify-content-center area-tabs mb-4" id="areaTabs" role="tablist">
            @foreach($areas as $index => $area)
                <li class="nav-item mx-1" role="presentation">
                    <button
                        class="nav-link area-tab-btn {{ $index === 0 ? 'active' : '' }}"
                        id="tab-{{ $index }}"
                        data-bs-toggle="pill"
                        data-bs-target="#area-{{ $index }}"
                        type="button"
                        role="tab"
                        aria-controls="area-{{ $index }}"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        style="--area-color: {{ $area['color'] }}"
                    >
                        <i class="fa-solid {{ $area['icono'] }} me-2"></i>{{ $area['nombre'] }}
                        <span class="badge bg-light text-dark ms-2">{{ count($area['empleados']) }}</span>
                    </button>
                </li>
            @endforeach
        </ul>

        {{-- Tab Content --}}
        <div class="tab-content" id="areaTabsContent">
            @foreach($areas as $index => $area)
                <div
                    class="tab-pane fade {{ $index === 0 ? 'show active' : '' }}"
                    id="area-{{ $index }}"
                    role="tabpanel"
                    aria-labelledby="tab-{{ $index }}"
                >
                    {{-- ======== TABLA DE EMPLEADOS ======== --}}
                    <div class="table-section mt-5 animate__animated animate__fadeInUp">
                        <div class="card card-custom">
                            <div class="card-header card-header-custom" style="background: linear-gradient(135deg, {{ $area['color'] }}, {{ $area['color'] }}99)">
                                <h4 class="mb-0 text-white">
                                    <i class="fa-solid fa-list-ol me-2"></i>
                                    Ranking Completo — {{ $area['nombre'] }}
                                </h4>
                            </div>
                            <div class="card-body p-0">
                                <table class="table table-hover table-ranking mb-0" id="table-{{ $index }}" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 80px">#</th>
                                            <th>Empleado</th>
                                            <th class="text-center" style="width: 140px">Puntos</th>
                                            <th class="text-center" style="width: 140px">Premio</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($area['empleados'] as $emp)
                                            <tr class="{{ $emp['medalla'] ? 'row-' . $emp['medalla'] : '' }} empleado-row"
                                                data-nombre="{{ $emp['nombre'] }}"
                                                data-puntos="{{ $emp['puntos'] }}"
                                                data-posicion="{{ $emp['posicion'] }}"
                                                data-medalla="{{ $emp['medalla'] ?? 'ninguna' }}"
                                                data-area="{{ $area['nombre'] }}"
                                            >
                                                <td class="text-center fw-bold">
                                                    @if($emp['posicion'] <= 3)
                                                        <span class="position-badge position-{{ $emp['medalla'] }}">
                                                            {{ $emp['posicion'] }}
                                                        </span>
                                                    @else
                                                        <span class="position-normal">{{ $emp['posicion'] }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="employee-avatar me-3 {{ $emp['medalla'] ? 'avatar-' . $emp['medalla'] : '' }}">
                                                            <i class="fa-solid fa-user table-avatar-icon"></i>
                                                        </div>
                                                        <div>
                                                            <span class="fw-semibold employee-name">{{ $emp['nombre'] }}</span>
                                                            @if($emp['medalla'])
                                                                <br><small class="text-muted">
                                                                    <i class="fa-solid fa-fire text-danger"></i> Top performer
                                                                </small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="text-center">
                                                    <span class="points-badge {{ $emp['medalla'] ? 'points-' . $emp['medalla'] : '' }}">
                                                        <i class="fa-solid fa-star me-1"></i>{{ number_format($emp['puntos']) }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @if($emp['medalla'] === 'oro')
                                                        <span class="medal-tag medal-tag-gold">
                                                            <i class="fa-solid fa-trophy me-1"></i> Oro
                                                        </span>
                                                    @elseif($emp['medalla'] === 'plata')
                                                        <span class="medal-tag medal-tag-silver">
                                                            <i class="fa-solid fa-medal me-1"></i> Plata
                                                        </span>
                                                    @elseif($emp['medalla'] === 'bronce')
                                                        <span class="medal-tag medal-tag-bronze">
                                                            <i class="fa-solid fa-medal me-1"></i> Bronce
                                                        </span>
                                                    @else
                                                        <span class="text-muted">
                                                            <i class="fa-solid fa-minus"></i>
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
