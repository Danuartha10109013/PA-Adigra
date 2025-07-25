@extends('backoffice.layout.main')

@section('content')

<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Absen Hari Ini</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item active">Absen Hari Ini</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content">

    <div class="row justify-content-center">
        <div class="col-md-12">

            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3 class="card-title">Absen</h3>

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

                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" absent="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <div class="row">
                        
                        <div class="col-md-4 mb-3">
                            <form action="/backoffice/absent/store" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                    <label for="jenis_absen"><strong>Jenis Absen</strong></label>
                                    <select class="form-control" id="jenis_absen" name="jenis_absen">
                                        <option value="WFO" selected>WFO (Work From Office)</option>
                                        <option value="WFH">WFH (Work From Home)</option>
                                    </select>
                                </div>
                                <div id="wfh_photo_group" class="form-group" style="display: none;">
                                    <label><strong>Foto Selfie (WFH)</strong></label>
                                    <div id="camera-container" style="text-align:center;">
                                        <video id="video" width="240" height="180" autoplay style="border-radius:8px; border:1px solid #ccc;"></video>
                                        <canvas id="canvas" width="240" height="180" style="display:none;"></canvas>
                                        <div id="countdown" style="font-size:2em; font-weight:bold; margin:10px 0; display:none;"></div>
                                        <button type="button" id="capture-btn" class="btn btn-primary btn-sm mt-2">Capture</button>
                                        <button type="button" id="retake-btn" class="btn btn-warning btn-sm mt-2" style="display:none;">Ulangi</button>
                                    </div>
                                    <input type="hidden" id="bukti_foto" name="bukti_foto">
                                    <small class="form-text text-muted">Ambil foto selfie saat WFH.</small>
                                </div>
                                <div class="card card-outline card-primary bg-light">
                                    <div class="card-body">

                                        <input type="hidden" id="latitude" name="latitude" class="form-control">
                                        <input type="hidden" id="longitude" name="longitude" class="form-control">

                                        <div class="form-group">
                                            <label><strong>Jam Kerja Minimal:</strong></label>
                                            <div class="alert alert-info">
                                                <i class="fas fa-clock"></i> {{ auth()->user()->minimum_work_hours }} jam per hari
                                            </div>
                                        </div>

                                        @if ($absentToday)
                                            @if ($absentToday->status == 'Absen')
                                                @if ($absentToday->start && !$absentToday->end)
                                                    <div class="alert alert-success">
                                                        <i class="fas fa-play"></i> Anda sudah absen masuk
                                                    </div>
                                                @elseif ($absentToday->end)
                                                    <div class="alert alert-success">
                                                        <i class="fas fa-check"></i> Anda sudah selesai bekerja hari ini
                                                    </div>
                                                @else
                                                    <div class="alert alert-primary">
                                                        <i class="fas fa-info-circle"></i> Silakan absen masuk untuk memulai kerja
                                                    </div>
                                                @endif
                                            @elseif ($absentToday->status == 'Meeting Keluar Kota')
                                                <div class="alert alert-info">
                                                    <i class="fas fa-plane"></i> Anda sedang dalam meeting keluar kota
                                                </div>
                                            @elseif ($absentToday->status == 'completed')
                                                <div class="alert alert-success">
                                                    <i class="fas fa-check-circle"></i> Meeting keluar kota sudah selesai, Anda bisa absen normal
                                                </div>
                                            @else
                                                <div class="alert alert-warning">
                                                    <i class="fas fa-info-circle"></i> Anda sedang {{ $absentToday->status }}
                                                </div>
                                            @endif
                                        @else
                                            <div class="alert alert-primary">
                                                <i class="fas fa-info-circle"></i> Silakan absen masuk untuk memulai kerja
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="card card-outline card-primary bg-light" style="height: 475px">
                                    <div class="card-body">
                                        <div class="text-center">
                                            <img src="{{ asset('images/tekmt.png') }}" class="img-fluid rounded" alt="">
                                        </div>
                                    </div>
                                </div>
                                @if ($absentToday)
                                    @if ($absentToday->status == 'Absen')
                                        @if ($absentToday->start && !$absentToday->end)
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <span class="fa fa-sign-out"></span> Absen Pulang
                                            </button>
                                        @elseif ($absentToday->end)
                                            <button type="button" class="btn btn-success btn-block" disabled>
                                                <span class="fa fa-check"></span> Anda Sudah Selesai Bekerja
                                            </button>
                                        @else
                                            <button type="submit" class="btn btn-primary btn-block">
                                                <span class="fa fa-sign-in"></span> Absen Masuk
                                            </button>
                                        @endif
                                    @elseif ($absentToday->status == 'Meeting Keluar Kota')
                                        <button type="button" class="btn btn-info btn-block" disabled>
                                            <span class="fa fa-plane"></span> Meeting Keluar Kota
                                        </button>
                                    @elseif ($absentToday->status == 'completed')
                                        <button type="submit" class="btn btn-primary btn-block">
                                            <span class="fa fa-sign-in"></span> Absen Masuk
                                        </button>
                                    @else
                                        <button type="button" class="btn btn-warning btn-block" disabled>
                                            <span class="fa fa-info-circle"></span> Anda sedang {{ $absentToday->status }}
                                        </button>
                                    @endif
                                @else
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <span class="fa fa-sign-in"></span> Absen Masuk
                                    </button>
                                @endif
                            </form>
                        </div>

                        <div class="col-md-8">
                            <div class="card card-outline card-primary bg-light">
                                <div class="card-body">
                                    <b> Hari: {{ \Carbon\Carbon::parse(date('Y-m-d'))->locale('id')->isoFormat('dddd, D
                                        MMMM YYYY') }} <br>
                                        Koordinat Anda: <span id="latitudeSpan"></span>, <span id="longitudeSpan"></span>
                                    </b>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card bg-success">
                                        <div class="card-body">
                                            <h3>Absen Masuk</h3>
                                            @if ($absentToday)
                                                @if ($absentToday->start == null)
                                                    @if ($absentToday->status == 'Absen')
                                                        Belum Absen
                                                    @elseif ($absentToday->status == 'Meeting Keluar Kota')
                                                        Meeting Keluar Kota
                                                    @elseif ($absentToday->status == 'completed')
                                                        Meeting Selesai
                                                    @else
                                                        {{ $absentToday->status }}
                                                    @endif
                                                @else
                                                    {{ \Carbon\Carbon::parse($absentToday->start)->format('H:i') }}
                                                @endif
                                            @else
                                                Belum Absen
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-warning">
                                        <div class="card-body">
                                            <h3>Absen Pulang</h3>
                                            @if ($absentToday)
                                                @if ($absentToday->end == null)
                                                    @if ($absentToday->status == 'Absen')
                                                        Belum Absen
                                                    @elseif ($absentToday->status == 'Meeting Keluar Kota')
                                                        Meeting Keluar Kota
                                                    @elseif ($absentToday->status == 'completed')
                                                        Meeting Selesai
                                                    @else
                                                        {{ $absentToday->status }}
                                                    @endif
                                                @else
                                                    {{ \Carbon\Carbon::parse($absentToday->end)->format('H:i') }}
                                                @endif
                                            @else
                                                Belum Absen
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-info">
                                        <div class="card-body">
                                            <h3>Jam Kerja</h3>
                                            @if ($absentToday && $absentToday->start)
                                                @if ($absentToday->end)
                                                    @php
                                                        $start = \Carbon\Carbon::parse($absentToday->start);
                                                        $end = \Carbon\Carbon::parse($absentToday->end);
                                                        $workMinutes = $end->diffInMinutes($start);
                                                        $workHours = floor($workMinutes / 60);
                                                        $workMinutesRemaining = $workMinutes % 60;
                                                    @endphp
                                                    @if ($workHours > 0)
                                                        {{ $workHours }} jam {{ $workMinutesRemaining }} menit
                                                    @else
                                                        {{ $workMinutesRemaining }} menit
                                                    @endif
                                                    @if ($workMinutes >= (auth()->user()->minimum_work_hours * 60))
                                                        <br><small class="text-success">✓ Minimal terpenuhi</small>
                                                    @else
                                                        <br><small class="text-danger">✗ Belum memenuhi minimal</small>
                                                    @endif
                                                @else
                                                    @php
                                                        $start = \Carbon\Carbon::parse($absentToday->start);
                                                        $current = \Carbon\Carbon::now();
                                                        $workMinutes = $current->diffInMinutes($start);
                                                        $workHours = floor($workMinutes / 60);
                                                        $workMinutesRemaining = $workMinutes % 60;
                                                        $requiredMinutes = auth()->user()->minimum_work_hours * 60;
                                                        $remainingMinutes = $requiredMinutes - $workMinutes;
                                                    @endphp
                                                    @if ($workHours > 0)
                                                        {{ $workHours }} jam {{ $workMinutesRemaining }} menit
                                                    @else
                                                        {{ $workMinutesRemaining }} menit
                                                    @endif
                                                    @if ($remainingMinutes > 0)
                                                        @php
                                                            $remainingHours = floor($remainingMinutes / 60);
                                                            $remainingMins = $remainingMinutes % 60;
                                                        @endphp
                                                        @if ($remainingHours > 0)
                                                            <br><small class="text-warning">⏰ Belum bisa pulang: {{ $remainingHours }} jam {{ $remainingMins }} menit lagi</small>
                                                        @else
                                                            <br><small class="text-warning">⏰ Belum bisa pulang: {{ $remainingMins }} menit lagi</small>
                                                        @endif
                                                    @else
                                                        <br><small class="text-success">✅ Minimal terpenuhi</small>
                                                    @endif
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="map" style="height: 400px"></div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <script>
            
            const map = L.map('map').setView([{{ auth()->user()->office->latitude }}, {{ auth()->user()->office->longitude }}], 13);
        
            const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
    
            // start marker
            var marker = L.marker([ {{ auth()->user()->office->latitude }} , {{ auth()->user()->office->longitude }} ])
                            .bindPopup('{{ auth()->user()->office->name }}')
                            .addTo(map);
                    
            var iconMarker = L.icon({
                iconUrl: 'https://cdn0.iconfinder.com/data/icons/small-n-flat/24/678111-map-marker-512.png',
                iconSize:     [50, 50], // size of the icon
                iconAnchor:   [25, 50], // point of the icon which will correspond to marker's location
                popupAnchor:  [-3, -76] // point from which the popup should open relative to the iconAnchor
            });

            // get location user
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                console.log(latitude, longitude);
                document.getElementById('latitudeSpan').innerHTML = latitude;
                document.getElementById('longitudeSpan').innerHTML = longitude;
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;

                var marker2 = L.marker([latitude, longitude], {
                    icon: iconMarker,
                    draggable: false
                })
                .bindPopup('Lokasi Anda')
                .addTo(map);
            });

            // end marker

            // start circle
            var circle = L.circle([ {{ auth()->user()->office->latitude }} ,  {{ auth()->user()->office->longitude }} ], {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: {{ auth()->user()->office->radius * 2 }}
            }).addTo(map).bindPopup('Radius Kantor');
            // end circle
        
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const jenisAbsen = document.getElementById('jenis_absen');
            const wfhPhotoGroup = document.getElementById('wfh_photo_group');
            const video = document.getElementById('video');
            const canvas = document.getElementById('canvas');
            const captureBtn = document.getElementById('capture-btn');
            const retakeBtn = document.getElementById('retake-btn');
            const countdown = document.getElementById('countdown');
            const buktiFotoInput = document.getElementById('bukti_foto');
            let stream = null;

            function showCamera() {
                wfhPhotoGroup.style.display = 'block';
                canvas.style.display = 'none';
                video.style.display = 'block';
                captureBtn.style.display = 'inline-block';
                retakeBtn.style.display = 'none';
                countdown.style.display = 'none';
                buktiFotoInput.value = '';
                if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    navigator.mediaDevices.getUserMedia({ video: true })
                        .then(function(s) {
                            stream = s;
                            video.srcObject = stream;
                            video.play();
                        })
                        .catch(function(err) {
                            alert('Tidak dapat mengakses kamera: ' + err.message);
                        });
                } else {
                    alert('Browser tidak mendukung kamera.');
                }
            }
            function hideCamera() {
                wfhPhotoGroup.style.display = 'none';
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                    stream = null;
                }
            }
            jenisAbsen.addEventListener('change', function() {
                if (this.value === 'WFH') {
                    showCamera();
                } else {
                    hideCamera();
                }
            });
            if (jenisAbsen.value === 'WFH') {
                showCamera();
            } else {
                hideCamera();
            }
            captureBtn.addEventListener('click', function() {
                countdown.style.display = 'block';
                let count = 3;
                countdown.textContent = count;
                captureBtn.disabled = true;
                const interval = setInterval(function() {
                    count--;
                    if (count > 0) {
                        countdown.textContent = count;
                    } else {
                        clearInterval(interval);
                        countdown.style.display = 'none';
                        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
                        canvas.style.display = 'block';
                        video.style.display = 'none';
                        captureBtn.style.display = 'none';
                        retakeBtn.style.display = 'inline-block';
                        // Simpan hasil capture ke input hidden
                        buktiFotoInput.value = canvas.toDataURL('image/png');
                        captureBtn.disabled = false;
                    }
                }, 1000);
            });
            retakeBtn.addEventListener('click', function() {
                canvas.style.display = 'none';
                video.style.display = 'block';
                captureBtn.style.display = 'inline-block';
                retakeBtn.style.display = 'none';
                buktiFotoInput.value = '';
            });
            // Validasi sebelum submit (WFH harus ada foto)
            document.querySelector('form').addEventListener('submit', function(e) {
                if (jenisAbsen.value === 'WFH' && !buktiFotoInput.value) {
                    e.preventDefault();
                    alert('Silakan ambil foto selfie terlebih dahulu!');
                }
            });
        });
    </script>

</section>

@endsection