@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form id="loginForm">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" id="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" id="password" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('loginForm').addEventListener('submit', async function(event) {
    event.preventDefault();
    
    let email = document.getElementById('email').value;
    let password = document.getElementById('password').value;

    try {
        let response = await axios.post('/login', { email, password });
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('role', response.data.role);

        if (response.data.role === 'admin') {
            window.location.href = "/admin/dashboard";
        } else {
            window.location.href = "/penumpang/dashboard";
        }
    } catch (error) {
        alert('Login gagal: ' + error.response.data.message);
    }
});
</script>
@endsection