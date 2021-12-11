<form method="POST" action="{{route('devs_post_login_pegawai')}}">
    @csrf
    <div class="form-group">
        <input type="text" class="form-control" name="username" id="username" placeholder="username" value="{{old('username')}}">
    </div>
    <div class="form-group">
        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
    </div>
    <button type="submit" class="btn btn-primary btn-block btn-submit">Masuk</button>
</form>