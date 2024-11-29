<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <form role="form" method="POST" action="/backoffice/user-data/user/create" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Pengguna</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="card card-outline card-primary">
                        <div class="card-body">

                            <div class="form-group">
                                <label>Nama <span class="text-danger">*</span></label>
                                <input type="text"  name="name" class="form-control @if($errors->has('name')) is-invalid @endif" placeholder="Nama" value="{{ old('name') }}"
                                required oninvalid="this.setCustomValidity('Nama harus diisi')"
                                oninput="this.setCustomValidity('')">
                                @if($errors->has('name'))
                                <small class="help-block" style="color: red">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label>Email <span class="text-danger">*</span></label>
                                <input type="email"  name="email" class="form-control @if($errors->has('email')) is-invalid @endif" placeholder="Email" value="{{ old('email') }}"
                                required oninvalid="this.setCustomValidity('Email harus diisi')"
                                oninput="this.setCustomValidity('')">
                                @if($errors->has('email'))
                                <small class="help-block" style="color: red">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                            <div class="form-group">
                                <label for="role">Peran <span class="text-danger">*</span></label>
                                <select name="role" id="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : '' }} select2" required
                                oninvalid="this.setCustomValidity('Peran harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}" {{ @old('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('role'))
                                <small class="text-danger">{{ $errors->first('role') }}</small>
                                @endif
                            </div>    
                            <div class="form-group">
                                <label for="office">Kantor <span class="text-danger">*</span></label>
                                <select name="office" id="office" class="form-control {{ $errors->has('office') ? 'is-invalid' : '' }} select2" required
                                oninvalid="this.setCustomValidity('Kantor harus diisi')" oninput="this.setCustomValidity('')">
                                    <option value="">-- Pilih --</option>
                                    @foreach ($offices as $office)
                                        <option value="{{ $office->id }}" {{ @old('office') == $office->id ? 'selected' : '' }}>{{ $office->name }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('office'))
                                <small class="text-danger">{{ $errors->first('office') }}</small>
                                @endif
                            </div>    
                            <div class="form-group">
                                <label>Password <span class="text-danger">*</span></label>
                                <input type="password"  name="password" class="form-control @if ($errors->has('password')) is-invalid @endif" placeholder="Password" value="{{ old('password') }}"
                                required oninvalid="this.setCustomValidity('Password harus diisi minimal 8 karakter')"
                                oninput="this.setCustomValidity('')">
                                @if($errors->has('password'))
                                <small class="help-block" style="color: red">{{ $errors->first('password') }}</small>
                                @endif
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
        const image = document.querySelector('#image')
        const imgPreview = document.querySelector('.img-preview')

        imgPreview.style.display = 'block'

        const oFReader = new FileReader()
        oFReader.readAsDataURL(image.files[0])

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result
        }
    }
</script>
{{--  --}}