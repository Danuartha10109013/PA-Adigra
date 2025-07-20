<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/meet/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Jadwal Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">

                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title"
                                    class="form-control @if($errors->has('judul')) is-invalid @endif" placeholder="Judul"
                                    value="{{ old('judul') }}" required
                                    oninvalid="this.setCustomValidity('Judul harus diisi')"
                                    oninput="this.setCustomValidity('')">
                                @if($errors->has('judul'))
                                <small class="help-block" style="color: red">{{ $errors->first('judul') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Kategori Meeting <span class="text-danger">*</span></label>
                                <select name="category" class="form-control" required onchange="toggleParticipants(this.value)">
                                    <option value="internal">Meeting Internal</option>
                                    <option value="online">Meeting Online</option>
                                    <option value="out_of_town">Meeting Keluar Kota</option>
                                </select>
                            </div>

                            <div class="form-group" id="participantsSection" style="display: none;">
                                <label>Peserta Meeting <span class="text-danger">*</span></label>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Pilih peserta yang akan mengikuti meeting keluar kota. Peserta yang dipilih akan otomatis tercatat sebagai izin.
                                </div>
                                
                                <!-- Tampilkan peserta yang sudah dipilih -->
                                <div id="selectedParticipants" class="mb-3" style="display: none;">
                                    <label class="font-weight-bold text-success">
                                        <i class="fas fa-check-circle"></i> Peserta yang Dipilih:
                                    </label>
                                    <div id="selectedParticipantsList" class="mt-2"></div>
                                </div>
                                
                                <select name="participants[]" id="participantsSelect" class="form-control select2" multiple data-placeholder="Pilih peserta meeting...">
                                    <optgroup label="Karyawan">
                                        @foreach($users->where('role_id', 2) as $user)
                                            @if(!isset($usersInMeeting) || !$usersInMeeting->contains($user->id))
                                                <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-position="{{ $user->position->name ?? '-' }}">
                                                    {{ $user->name }} ({{ $user->position->name ?? '-' }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                    <optgroup label="Admin">
                                        @foreach($users->where('role_id', 1) as $user)
                                            @if(!isset($usersInMeeting) || !$usersInMeeting->contains($user->id))
                                                <option value="{{ $user->id }}" data-name="{{ $user->name }}" data-position="{{ $user->position->name ?? '-' }}">
                                                    {{ $user->name }} ({{ $user->position->name ?? '-' }})
                                                </option>
                                            @endif
                                        @endforeach
                                    </optgroup>
                                </select>
                                
                                <!-- Tampilkan user yang sedang dalam meeting -->
                                @if(isset($usersInMeeting) && $usersInMeeting->count() > 0)
                                    <div class="mt-3">
                                        <label class="font-weight-bold text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> User yang Sedang dalam Meeting:
                                        </label>
                                        <div class="alert alert-warning mt-2">
                                            @foreach($users as $user)
                                                @if($usersInMeeting->contains($user->id))
                                                    <div class="mb-1">
                                                        <i class="fas fa-user-clock"></i> 
                                                        {{ $user->name }} ({{ $user->position->name ?? '-' }})
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                
                                <small class="form-text text-muted">
                                    <i class="fas fa-exclamation-circle"></i> Peserta yang dipilih akan menerima notifikasi meeting
                                </small>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="form-group mx-4">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="date" min="{{ date('Y-m-d') }}"
                                        class="form-control @if($errors->has('date')) is-invalid @endif"
                                        placeholder="date" value="{{ old('date') }}" required
                                        oninvalid="this.setCustomValidity('date harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                    @if($errors->has('date'))
                                    <small class="help-block" style="color: red">{{ $errors->first('date') }}</small>
                                    @endif
                                </div>
                                <div class="form-group mx-4">
                                    <label>Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="start"
                                        class="form-control @if($errors->has('start')) is-invalid @endif"
                                        placeholder="start" value="{{ old('start') }}" required
                                        oninvalid="this.setCustomValidity('start harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                    @if($errors->has('start'))
                                    <small class="help-block" style="color: red">{{ $errors->first('start') }}</small>
                                    @endif
                                </div>
                                <div class="form-group mx-4">
                                    <label>Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="end"
                                        class="form-control @if($errors->has('end')) is-invalid @endif"
                                        placeholder="end" value="{{ old('end') }}" required
                                        oninvalid="this.setCustomValidity('end harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                    @if($errors->has('end'))
                                    <small class="help-block" style="color: red">{{ $errors->first('end') }}</small>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal"><span
                                class="fa fa-arrow-left"></span> Kembali</button>
                        <button type="submit" class="btn btn-success"><span class="fa fa-save"></span> Simpan</button>
                    </div>
            </form>
        </div>
    </div>
</div>

{{--  --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
    function previewImg() {
        const image = document.querySelector('#image')
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block'

        const oFReader = new FileReader()
        oFReader.readAsDataURL(image.files[0])

        oFReader.onload = function (oFREvent) {
            imgPreview.src = oFREvent.target.result
        }
    }

    function toggleParticipants(category) {
        const participantsSection = document.getElementById('participantsSection');
        if (category === 'out_of_town') {
            participantsSection.style.display = 'block';
            // Reinitialize select2 when shown
            $('#participantsSelect').select2({
                width: '100%',
                placeholder: "Pilih peserta meeting...",
                allowClear: true,
                theme: "classic",
                templateResult: function (data) {
                    // Jika sudah dipilih, jangan tampilkan di dropdown
                    var selected = $('#participantsSelect').val() || [];
                    if (selected.includes(data.id)) {
                        return null;
                    }
                    return data.text;
                }
            });
            
            // Update tampilan peserta yang dipilih
            updateSelectedParticipants();
        } else {
            participantsSection.style.display = 'none';
            // Reset pilihan peserta
            $('#participantsSelect').val(null).trigger('change');
            $('#selectedParticipants').hide();
        }
    }

    function updateSelectedParticipants() {
        const selectedValues = $('#participantsSelect').val();
        const selectedParticipantsDiv = $('#selectedParticipants');
        const selectedParticipantsList = $('#selectedParticipantsList');
        
        if (selectedValues && selectedValues.length > 0) {
            selectedParticipantsList.empty();
            selectedValues.forEach(function(value) {
                const option = $(`#participantsSelect option[value="${value}"]`);
                const name = option.data('name');
                const position = option.data('position');
                
                selectedParticipantsList.append(`
                    <div class="badge badge-success mr-2 mb-2 p-2">
                        <i class="fas fa-user-check"></i> ${name} (${position})
                    </div>
                `);
            });
            selectedParticipantsDiv.show();
        } else {
            selectedParticipantsDiv.hide();
        }
    }

    function hideSelectedOptions() {
        var selected = $('#participantsSelect').val();
        $('#participantsSelect option').show();
        if (selected) {
            selected.forEach(function(val) {
                $('#participantsSelect option[value="' + val + '"]').hide();
            });
        }
    }

    $(document).ready(function() {
        // Initialize select2 with custom styling
        $('#participantsSelect').select2({
            width: '100%',
            placeholder: "Pilih peserta meeting...",
            allowClear: true,
            theme: "classic",
            templateResult: function (data) {
                // Jika sudah dipilih, jangan tampilkan di dropdown
                var selected = $('#participantsSelect').val() || [];
                if (selected.includes(data.id)) {
                    return null;
                }
                return data.text;
            }
        }).on('select2:open', function() {
            $('.select2-dropdown').addClass('select2-dropdown-custom');
        }).on('change', function() {
            updateSelectedParticipants();
            hideSelectedOptions();
        });
        
        // Sembunyikan opsi yang sudah dipilih
        $('#participantsSelect').on('select2:select', function(e) {
            hideSelectedOptions();
        });

        // Saat peserta di-unselect
        $('#participantsSelect').on('select2:unselect', function(e) {
            hideSelectedOptions();
        });

        // Saat modal dibuka, pastikan opsi yang sudah dipilih disembunyikan
        $('#tambah').on('shown.bs.modal', function() {
            hideSelectedOptions();
            if ($('select[name="category"]').val() === 'out_of_town') {
                updateSelectedParticipants();
            }
        });
    });
</script>

<style>
    .select2-container--classic .select2-selection--multiple {
        min-height: 100px;
        border: 1px solid #ced4da;
    }
    .select2-container--classic .select2-selection--multiple .select2-selection__choice {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 5px 10px;
        margin: 2px;
    }
    .select2-container--classic .select2-selection--multiple .select2-selection__choice__remove {
        color: white;
        margin-right: 5px;
    }
    .select2-dropdown-custom {
        border: 1px solid #ced4da;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .alert-info {
        padding: 10px 15px;
        margin-bottom: 15px;
        border-radius: 4px;
    }
    .badge-success {
        background-color: #28a745;
        color: white;
        font-size: 0.875rem;
        border-radius: 20px;
    }
    .badge-success i {
        margin-right: 5px;
    }
    .alert-warning {
        background-color: #fff3cd;
        border-color: #ffeaa7;
        color: #856404;
        padding: 10px 15px;
        border-radius: 4px;
    }
    .font-weight-bold {
        font-weight: 600;
    }
    .text-success {
        color: #28a745 !important;
    }
    .text-warning {
        color: #ffc107 !important;
    }
</style>
{{--  --}}
