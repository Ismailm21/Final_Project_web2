<form method="POST" action="{{ route('driver.verify.otp.submit') }}">
    @csrf
    <input type="hidden" name="user_id" value="{{ $userId }}">
    <input type="text" name="otp_code" placeholder="Enter OTP" required>
    <button type="submit">Verify</button>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</form>
