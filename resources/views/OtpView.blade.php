<form method="POST" action="{{ route('verify.otp.submit') }}">
    @csrf
    @if ($errors->any())
        <div class="alert alert-danger" style="color: red; margin-bottom: 10px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="text" name="otp_code" placeholder="Enter OTP" required>
    <button type="submit">Verify</button>
</form>
