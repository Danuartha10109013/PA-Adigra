@if ($errors->any())
    <script>
        jQuery(function() {
            $('#edit-password-{{ $user->id }}').modal('show');
        });
    </script>
@endif

@if(session('error'))
    <script>
        jQuery(function() {
            $('#edit-password-{{ $user->id }}').modal('show');
        });
    </script>
@endif

<div class="modal fade" id="edit-password-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            {{-- show error validation --}}
            {{ $errors->any() ? $errors->first() : '' }}

            <form role="form" method="POST" action="/backoffice/user-data/user/{{ $user->id }}/update-password" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Gagal </strong>{{ session('error') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif
                    <div class="card card-outline card-primary">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="password_sekarang">Password Sekarang <span class="text-danger">*</span></label>
                                <input type="password"  name="password_sekarang" class="form-control @if ($errors->has('password_sekarang')) is-invalid @endif" placeholder="Password Sekarang" value="{{ old('password_sekarang') }}">
                                @if($errors->has('password_sekarang'))
                                <small class="help-block" style="color: red">{{ $errors->first('password_sekarang') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="password_baru">Password Baru <span class="text-danger">*</span></label>
                                <input type="password"  name="password_baru" class="form-control @if ($errors->has('password_baru')) is-invalid @endif" placeholder="Password Baru" value="{{ old('password_baru') }}">
                                @if($errors->has('password_baru'))
                                <small class="help-block" style="color: red">{{ $errors->first('password_baru') }}</small>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="konfirmasi_password">Password Sekarang <span class="text-danger">*</span></label>
                                <input type="password"  name="konfirmasi_password" class="form-control @if ($errors->has('konfirmasi_password')) is-invalid @endif" placeholder="Konfirmasi Password" value="{{ old('konfirmasi_password') }}">
                                @if($errors->has('konfirmasi_password'))
                                <small class="help-block" style="color: red">{{ $errors->first('konfirmasi_password') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal"><span class="fa fa-arrow-left"></span> Kembali</button>
                    <button type="submit" class="btn btn-success"><span class="fa fa-edit"></span> Ubah</button>
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