<form method="POST" action="{{route('devs_post_create_pegawai')}}">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama" value="{{old('nama')}}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="alamat" id="alamat" placeholder="alamat" value="{{old('alamat')}}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="hp" id="hp" placeholder="hp" value="{{old('hp')}}">
    </div>
    <div class="form-group">
        <input type="text" class="form-control" name="roles" id="roles" placeholder="roles" value="{{old('roles')}}">
    </div>
    
    <div class="form-group">
        <input type="text" class="form-control" name="username" id="username" placeholder="username" value="{{old('username')}}">
    </div>

    <div class="form-group">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="password_confirmation">
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-submit">Masuk</button>
</form>