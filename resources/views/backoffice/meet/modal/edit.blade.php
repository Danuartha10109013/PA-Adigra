<div class="modal fade" id="edit-{{ $meet->id }}" tabindex="-1" aria-labelledby="editLabel{{ $meet->id }}"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/meet/{{ $meet->id }}/update">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editLabel{{ $meet->id }}">Edit Jadwal Meeting</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label>Judul <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control" value="{{ $meet->title }}"
                                    required>
                            </div>

                            <div class="form-group">
                                <label>Kategori Meeting <span class="text-danger">*</span></label>
                                <select name="category" class="form-control" required
                                    onchange="toggleParticipantsEdit(this.value, {{ $meet->id }})">
                                    <option value="internal" {{ $meet->category == 'internal' ? 'selected' : '' }}>Meeting
                                        Internal</option>
                                    <option value="online" {{ $meet->category == 'online' ? 'selected' : '' }}>Meeting
                                        Online</option>
                                    <option value="out_of_town" {{ $meet->category == 'out_of_town' ? 'selected' : '' }}>
                                        Meeting Keluar Kota</option>
                                </select>
                            </div>

                            <div class="form-group" id="participantsSectionEdit{{ $meet->id }}"
                                style="display: {{ $meet->category == 'out_of_town' ? 'block' : 'none' }};">
                                <label>Peserta Meeting <span class="text-danger">*</span></label>
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle"></i> Pilih peserta yang akan mengikuti meeting keluar
                                    kota. Peserta yang dipilih akan otomatis tercatat sebagai izin.
                                </div>
                                @if($meet->status !== 'pending')
                                    <div class="alert alert-warning mt-2">
                                        Meeting sudah tidak berstatus <b>pending</b>, peserta tidak dapat diedit.
                                    </div>
                                @endif
                                <!-- Tampilkan peserta yang sudah dipilih (peserta awal) -->
                                <div class="mb-2">
                                    <label class="font-weight-bold text-primary">
                                        <i class="fas fa-users"></i> Peserta Meeting Saat Ini:
                                    </label>
                                    <ul class="mb-2" id="currentParticipantsListEdit{{ $meet->id }}">
                                        @foreach($meet->participants as $participant)
                                            <li style="display: flex; align-items: center;">
                                                <span>{{ $participant->name }} ({{ $participant->position->name ?? '-' }})</span>
                                                <input type="hidden" name="participants[]" value="{{ $participant->id }}">
                                                <button type="button" class="btn btn-sm btn-danger ml-2 btn-unselect-participant-edit" data-meet-id="{{ $meet->id }}" data-user-id="{{ $participant->id }}" title="Hapus dari peserta">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- Tombol edit peserta -->
                                    <button type="button" class="btn btn-primary btn-sm mb-2" onclick="showAddParticipantDropdown({{ $meet->id }})">
                                        <i class="fas fa-plus"></i> Edit Peserta
                                    </button>
                                    <div id="addParticipantSectionEdit{{ $meet->id }}" style="display:none;">
                                        <select class="form-control mb-2" id="addParticipantSelectEdit{{ $meet->id }}">
                                            <option value="">-- Pilih Peserta --</option>
                                            @foreach($users as $user)
                                                @if(!$meet->participants->contains($user->id) && !$meet->usersInMeetingEdit->contains($user->id))
                                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->position->name ?? '-' }})</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        <button type="button" class="btn btn-success btn-sm" onclick="addParticipantToList({{ $meet->id }})">Edit</button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="hideAddParticipantDropdown({{ $meet->id }})">Batal</button>
                                    </div>
                                </div>
                                <!-- Tampilkan peserta yang sudah dipilih -->
                                <div id="selectedParticipantsEdit{{ $meet->id }}" class="mb-3" style="display: none;">
                                    <label class="font-weight-bold text-success">
                                        <i class="fas fa-check-circle"></i> Peserta yang Dipilih:
                                    </label>
                                    <div id="selectedParticipantsListEdit{{ $meet->id }}" class="mt-2"></div>
                                </div>

                                <!-- Tampilkan user yang sedang dalam meeting -->
                                @if(isset($usersInMeeting) && $usersInMeeting->count() > 0)
                                    <div class="mt-3">
                                        <label class="font-weight-bold text-warning">
                                            <i class="fas fa-exclamation-triangle"></i> User yang Sedang dalam Meeting:
                                        </label>
                                        <div class="alert alert-warning mt-2">
                                            @foreach($users as $user)
                                                @if($usersInMeeting->contains($user->id) && !$meet->participants->contains($user->id))
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
                                    <i class="fas fa-exclamation-circle"></i> Peserta yang dipilih akan menerima
                                    notifikasi meeting
                                </small>
                            </div>

                            <div class="d-flex justify-content-center">
                                <div class="form-group mx-4">
                                    <label>Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" name="date" class="form-control" value="{{ $meet->date }}"
                                        required>
                                </div>
                                <div class="form-group mx-4">
                                    <label>Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" name="start" class="form-control" value="{{ $meet->start }}"
                                        required>
                                </div>
                                <div class="form-group mx-4">
                                    <label>Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" name="end" class="form-control" value="{{ $meet->end }}"
                                        required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </button>
                    <button type="submit" class="btn btn-success" @if($meet->status !== 'pending') disabled @endif>
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
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

    function toggleParticipantsEdit(category, meetId) {
        const participantsSection = document.getElementById(`participantsSectionEdit${meetId}`);
        if (category === 'out_of_town') {
            participantsSection.style.display = 'block';
            $(`#participantsSelectEdit${meetId}`).select2({
                width: '100%',
                placeholder: "Pilih peserta meeting...",
                allowClear: true,
                theme: "classic"
            });
            updateSelectedParticipantsEdit(meetId);
        } else {
            participantsSection.style.display = 'none';
            $(`#participantsSelectEdit${meetId}`).val(null).trigger('change');
            $(`#selectedParticipantsEdit${meetId}`).hide();
        }
    }

    function updateSelectedParticipantsEdit(meetId) {
        const selectedValues = $(`#participantsSelectEdit${meetId}`).val();
        const selectedParticipantsDiv = $(`#selectedParticipantsEdit${meetId}`);
        const selectedParticipantsList = $(`#selectedParticipantsListEdit${meetId}`);

        if (selectedValues && selectedValues.length > 0) {
            selectedParticipantsList.empty();
            selectedValues.forEach(function (value) {
                const option = $(`#participantsSelectEdit${meetId} option[value="${value}"]`);
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

    function hideSelectedOptionsEdit(meetId) {
        var selected = $(`#participantsSelectEdit${meetId}`).val();
        $(`#participantsSelectEdit${meetId} option`).show();
        if (selected) {
            selected.forEach(function (val) {
                $(`#participantsSelectEdit${meetId} option[value="${val}"]`).hide();
            });
        }
    }

    function refreshSelect2(meetId) {
        var $select = $(`#participantsSelectEdit${meetId}`);
        $select.select2('destroy');
        $select.select2({
            width: '100%',
            placeholder: "Pilih peserta meeting...",
            allowClear: true,
            theme: "classic"
        });
    }

    // Ambil data peserta dari Blade ke JS
    @php
        $usersArray = $users->map(function($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'position' => $user->position->name ?? '-',
                'role_id' => $user->role_id
            ];
        })->values();
    @endphp
    var participantsDataEdit = @json($usersArray);
    var participantsInMeetingEdit = @json($usersInMeeting ?? []);
    var selectedParticipantsEdit = @json($meet->participants->pluck('id')->toArray());

    function renderParticipantsSelectEdit(meetId) {
        var $select = $(`#participantsSelectEdit${meetId}`);
        var selected = $select.val() || [];
        var html = '';
        var optgroups = {2: [], 1: []};
        participantsDataEdit.forEach(function(user) {
            var isInMeeting = participantsInMeetingEdit.includes(user.id);
            var isSelected = selected.includes(user.id.toString()) || selected.includes(user.id);
            if (isSelected) {
                optgroups[user.role_id].push(`<option value="${user.id}" data-name="${user.name}" data-position="${user.position}" selected>${user.name} (${user.position})</option>`);
            } else if (!isInMeeting) {
                optgroups[user.role_id].push(`<option value="${user.id}" data-name="${user.name}" data-position="${user.position}">${user.name} (${user.position})</option>`);
            }
        });
        html += '<optgroup label="Karyawan">' + optgroups[2].join('') + '</optgroup>';
        html += '<optgroup label="Admin">' + optgroups[1].join('') + '</optgroup>';
        $select.html(html);
    }

    function showAddParticipantDropdown(meetId) {
        document.getElementById('addParticipantSectionEdit' + meetId).style.display = 'block';
    }
    function hideAddParticipantDropdown(meetId) {
        document.getElementById('addParticipantSectionEdit' + meetId).style.display = 'none';
    }
    function addParticipantToList(meetId) {
        var select = document.getElementById('addParticipantSelectEdit' + meetId);
        var userId = select.value;
        if (!userId) return;
        var userName = select.options[select.selectedIndex].text;
        // Tambahkan ke list
        var ul = document.getElementById('currentParticipantsListEdit' + meetId);
        var li = document.createElement('li');
        li.style.display = 'flex';
        li.style.alignItems = 'center';
        li.innerHTML = '<span>' + userName + '</span>' +
            '<input type="hidden" name="participants[]" value="' + userId + '">' +
            '<button type="button" class="btn btn-sm btn-danger ml-2 btn-unselect-participant-edit" data-meet-id="' + meetId + '" data-user-id="' + userId + '" title="Hapus dari peserta"><i class="fas fa-times"></i></button>';
        ul.appendChild(li);
        // Hapus dari dropdown
        select.remove(select.selectedIndex);
        select.value = '';
    }

    $(document).ready(function () {
        // Inisialisasi select2 setiap kali modal edit dibuka
        $('[id^="edit-"]').on('shown.bs.modal', function () {
            var meetId = $(this).attr('id').replace('edit-', '');
            $(`#participantsSelectEdit${meetId}`).select2({
                width: '100%',
                placeholder: "Pilih peserta meeting...",
                allowClear: true,
                theme: "classic"
                // Tidak ada templateResult atau matcher custom!
            });
        });

        // Unselect peserta dari daftar awal (dan dari hasil tambah)
        $(document).on('click', '.btn-unselect-participant-edit', function() {
            var meetId = $(this).data('meet-id');
            var userId = $(this).data('user-id').toString();
            // Hapus elemen dari list
            $(this).closest('li').remove();
            // Tambahkan kembali ke dropdown tambah peserta
            var select = document.getElementById('addParticipantSelectEdit' + meetId);
            if (select) {
                // Cari nama peserta dari span
                var userName = $(this).siblings('span').text();
                // Cek apakah sudah ada di dropdown
                var exists = false;
                for (var i = 0; i < select.options.length; i++) {
                    if (select.options[i].value == userId) { exists = true; break; }
                }
                if (!exists) {
                    var option = document.createElement('option');
                    option.value = userId;
                    option.text = userName;
                    select.appendChild(option);
                }
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
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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