@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Detail Absensi Saya</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">Detail Absensi Saya</li>
          </ol>
        </div>
      </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <!-- Default box -->
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Detail Absensi</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse"
                            data-toggle="tooltip" title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>

                </div>
                <div class="card-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" absent="alert">
                        <strong>Berhasil </strong>{{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card card-outline card-primary bg-light">
                                <div class="card-body">
                                    <h4 class="text-center">Lokasi Koordinat Absen</h4>
                                    <div id="map" style="height: 400px"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">

                            @if ($absent->status != 'Absen')
                                <div class="card bg-warning">
                                    <div class="card-body">
                                        <h3>
                                            <b>
                                                @if ($absent->status == 'Meeting Keluar Kota')
                                                    Anda sedang dalam Meeting Keluar Kota
                                                @elseif ($absent->status == 'completed')
                                                    Meeting Keluar Kota sudah selesai
                                                @else
                                                    Anda sedang {{ $absent->status }}
                                                @endif
                                            </b>
                                        </h3>
                                        <b>Keterangan:</b> {{ $absent->description ?: 'Tidak ada keterangan' }}
                                    </div>
                                </div>
                            @endif

                            <div class="card card-outline card-primary bg-light">
                                <div class="card-body">

                                    <p>Hari: <b>{{  \Carbon\Carbon::parse($absent->date)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</b></p>
                                    <p>Nama Kantor: <b>{{ $absent->office ? $absent->office->name : 'Tidak ada data kantor' }}</b></p>
                                    <p>Alamat Kantor: <b>{{ $absent->office ? $absent->office->address : 'Tidak ada data alamat' }}</b></p>
                                    <p>Radius Kantor: <b>{{ $absent->office ? $absent->office->radius . ' Meter' : 'Tidak ada data radius' }}</b></p>
                                    <p>Jam Kerja Minimal: <b>{{ $absent->user ? $absent->user->minimum_work_hours : 5 }} jam per hari</b></p>
                                    <p>Jam Masuk: <b>{{ $absent->start ? \Carbon\Carbon::parse($absent->start)->format('H:i') : '-' }}</b></p>
                                    <p>Jam Keluar: <b>{{ $absent->end ? \Carbon\Carbon::parse($absent->end)->format('H:i') : '-' }}</b></p>
                                    <p>Total Jam Kerja: 
                                        <b>
                                            @if ($absent->start && $absent->end)
                                                @php
                                                    $start = \Carbon\Carbon::parse($absent->start);
                                                    $end = \Carbon\Carbon::parse($absent->end);
                                                    $workMinutes = $end->diffInMinutes($start);
                                                    $workHours = floor($workMinutes / 60);
                                                    $workMinutesRemaining = $workMinutes % 60;
                                                @endphp
                                                @if ($workHours > 0)
                                                    {{ $workHours }} jam {{ $workMinutesRemaining }} menit
                                                @else
                                                    {{ $workMinutesRemaining }} menit
                                                @endif
                                            @elseif ($absent->start && !$absent->end)
                                                @php
                                                    $start = \Carbon\Carbon::parse($absent->start);
                                                    $current = \Carbon\Carbon::now();
                                                    $workMinutes = $current->diffInMinutes($start);
                                                    $workHours = floor($workMinutes / 60);
                                                    $workMinutesRemaining = $workMinutes % 60;
                                                @endphp
                                                @if ($workHours > 0)
                                                    {{ $workHours }} jam {{ $workMinutesRemaining }} menit
                                                @else
                                                    {{ $workMinutesRemaining }} menit
                                                @endif
                                                <br><small class="text-info">(Sedang bekerja)</small>
                                            @else
                                                -
                                            @endif
                                        </b>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
        @if($absent->office)
            const map = L.map('map').setView([{{ $absent->office->latitude }}, {{ $absent->office->longitude }}], 13);
            
            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
    
            // start marker
            var marker = L.marker([{{ $absent->office->latitude }},{{ $absent->office->longitude }}])
                                .bindPopup('Lokasi kantor')
                                .addTo(map);
                        
            var iconMarker = L.icon({
                iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png',
                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [25, 50], // point of the icon which will correspond to marker's location
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });

            // start circle
            var circle = L.circle([{{ $absent->office->latitude }}, {{ $absent->office->longitude }}], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ $absent->office->radius * 2 }}
            }).addTo(map).bindPopup('Radius Kantor');
            // end circle
        @else
            // Jika tidak ada data office, tampilkan pesan
            document.getElementById('map').innerHTML = '<div class="alert alert-warning text-center">Tidak ada data lokasi kantor</div>';
        @endif
    </script>

</section>

@endsection