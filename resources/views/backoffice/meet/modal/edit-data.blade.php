<div class="modal fade" id="edit-data-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/user-data/user/{{ $user->id }}/update-data" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama <span class="text-danger">*</span></label>
                                        <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" placeholder="Nama" value="{{ $user->name }}"
                                        oninvalid="this.setCustomValidity('Nama harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                        @if($errors->has('name'))
                                        <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="gender">Jenis kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" id="gender" class="form-control {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                            required oninvalid="this.setCustomValidity('Jenis kelamin harus diisi')"
                                            oninput="this.setCustomValidity('')">
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-laki" {{ $user->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ $user->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @if ($errors->has('gender'))
                                        <small class="text-danger">{{ $errors->first('gender') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="religion">Agama <span class="text-danger">*</span></label>
                                        <select name="religion" id="religion" class="form-control {{ $errors->has('religion') ? 'is-invalid' : '' }}"
                                            required oninvalid="this.setCustomValidity('Agama harus diisi')"
                                            oninput="this.setCustomValidity('')">
                                            <option value="">-- Pilih --</option>
                                            <option value="Islam" {{ $user->religion == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ $user->religion == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ $user->religion == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ $user->religion == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Budha" {{ $user->religion == 'Budha' ? 'selected' : '' }}>Budha</option>
                                            <option value="Konghucu" {{ $user->religion == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                        @if ($errors->has('religion'))
                                        <small class="text-danger">{{ $errors->first('religion') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Alamat <span class="text-danger">*</span></label>
                                        <textarea name="address" id="address" class="form-control @if ($errors->has('address')) is-invalid @endif"
                                            required oninvalid="this.setCustomValidity('Alamat harus diisi')"
                                            oninput="this.setCustomValidity('')">{{ $user->address }}</textarea>
                                        @if ($errors->has('address'))
                                        <small class="text-danger">{{ $errors->first('address') }}</small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="place_birth">Tempat Lahir <span class="text-danger">*</span></label>
                                        <input type="text" name="place_birth" id="place_birth"
                                            class="form-control @if ($errors->has('place_birth')) is-invalid @endif"
                                            value="{{ $user->place_birth }}"
                                            required oninvalid="this.setCustomValidity('Tempat lahir harus diisi')"
                                            oninput="this.setCustomValidity('')">
                                        @if ($errors->has('place_birth'))
                                        <small class="text-danger">{{ $errors->first('place_birth') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="date_birth">Tanggal Lahir <span class="text-danger">*</span></label>
                                        <input type="date" max="{{ date('Y-m-d') }}" name="date_birth" id="date_birth"
                                            class="form-control @if ($errors->has('date_birth')) is-invalid @endif"
                                            value="{{ $user->date_birth }}"
                                            required oninvalid="this.setCustomValidity('Tanggal lahir harus diisi')"
                                            oninput="this.setCustomValidity('')">
                                        @if ($errors->has('date_birth'))
                                        <small class="text-danger">{{ $errors->first('date_birth') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="no_hp">No. HP <span class="text-danger">*</span></label>
                                        <input type="text" name="no_hp" id="no_hp" class="form-control @if ($errors->has('no_hp')) is-invalid @endif" value="{{ $user->no_hp }}"
                                        required oninvalid="this.setCustomValidity('No. Hp harus diisi')"
                                        oninput="this.setCustomValidity('')">
                                        @if ($errors->has('no_hp'))
                                        <small class="text-danger">{{ $errors->first('no_hp') }}</small>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="foto">Foto</label>
                                        @if ($user->foto)
                                            <img src="{{ Storage::disk('local')->url($user->foto) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block"
                                            style="width: 150px; height: 150px">
                                        @else
                                            <img class="img-preview img-fluid mb-3 col-sm-5">
                                        @endif
                                            <input type="file" accept="image/*" name="foto" class="form-control @if($errors->has('foto')) is-invalid @endif" id="img-preview" onchange="previewImg()">
                                        @if($errors->has('foto'))
                                            <small class="help-block" style="color: red">{{ $errors->first('foto') }}</small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
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
        const image = document.querySelector('#img-preview')
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block'
        imgPreview.style.width = '150px'
        imgPreview.style.height = '150px'

        const oFReader = new FileReader()
        oFReader.readAsDataURL(image.files[0])

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result
        }
    }
</script>
{{--  --}}