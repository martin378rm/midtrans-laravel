<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('login-page/dist/output.css')}}">
    <title>Register Page</title>
</head>

<body>
    <div class="flex py-10 md:py-20 px-5 md:px-32 bg-gray-200 min-h-screen">
        <div class="flex shadow w-full flex-col-reverse lg:flex-row">
            <div class="w-full lg:w-1/2 bg-white p-10 px-5 md:px-20">
                <h1 class="font-bold text-xl text-gray-700">Register Page</h1>
                <p class="text-gray-600">Please fill all column to create your account!</p>

                @if (Session::has('message'))
                    <div style="color: red">
                        @foreach (Session::get('message') as $item)
                            <p>{{$item[0]}}</p>
                        @endforeach
                    </div>
                @endif
                <form action="/register_member" class="mt-10" method="POST">
                    @csrf
                    <div class="my-3">
                        <label class="font-semibold" for="nama_member">Nama</label>
                        <input type="text" placeholder="Nama" name="nama_member" id="nama_member"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="email">E-mail</label>
                        <input type="text" placeholder="E-mail" name="email" id="email"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="no_hp">No Handphone</label>
                        <input type="text" placeholder="No Handphone" name="no_hp" id="no_hp"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="detail_alamat">Alamat</label>
                        <input type="text" placeholder="Alamat" name="detail_alamat" id="detail_alamat"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="provinsi">Provinsi</label>
                        <input type="text" placeholder="Provinsi" name="provinsi" id="provinsi"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="kabupaten">Kabupaten</label>
                        <input type="text" placeholder="Kabupaten" name="kabupaten" id="kabupaten"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="kecamatan">Kecamatan</label>
                        <input type="text" placeholder="Kecamatan" name="kecamatan" id="kecamatan"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="konfirmasi_password">Konfirmasi Password</label>
                        <input type="password" placeholder="konfirmasi_password" name="konfirmasi_password" id="konfirmasi_password"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-3">
                        <label class="font-semibold" for="password">Password</label>
                        <input type="password" placeholder="password" name="password" id="password"
                            class="block border-2 rounded-full mt-2 py-2 px-5 w-full" required>
                    </div>
                    <div class="my-5">
                        <button type="submit"
                            class="w-full rounded-full bg-blue-400 hover:bg-blue-600 text-white py-2">REGISTER
                        </button>
                    </div>
                </form>
                <span>Have an account? <a href="/login_member" class="text-blue-400 hover:text-blue-600">Login here.</a></span>
            </div>
            <div class="w-full lg:w-1/2 bg-blue-400 flex justify-center items-center">
                <img src="{{asset('login-page/src/register.svg')}}" alt="Login Image" class="w-full">
            </div>
        </div>
    </div>
</body>

</html>
