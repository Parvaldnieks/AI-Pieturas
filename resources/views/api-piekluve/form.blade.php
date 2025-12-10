<style>
    body {
        font-family: Arial, sans-serif;
        background-color: #fff7f0;
        margin: 0;
        padding: 0;
    }

    h2 {
        text-align: center;
        margin-top: 2rem;
        font-size: 2rem;
        color: #ff7a22;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        width: 100%;
        max-width: 30rem;
        margin: 2rem auto;
        padding: 2rem;
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 4px 10px rgba(255, 125, 42, 0.25);
    }

    form > div {
        margin-bottom: 1.5rem;
        width: 100%;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #d55800;
        text-align: left;
    }

    select, input, textarea {
        width: 100%;
        padding: 0.6rem;
        font-size: 1rem;
        border: 1px solid #ffb684;
        border-radius: 0.3rem;
        transition: border-color 0.2s, box-shadow 0.2s;
        background-color: #fffdfa;
    }

    select:focus, input:focus, textarea:focus {
        border-color: #ff7a22;
        box-shadow: 0 0 4px rgba(255, 122, 34, 0.4);
        outline: none;
    }

    textarea {
        resize: vertical;
        min-height: 80px;
    }

    button[type="submit"] {
        width: 100%;
        background-color: #ff7a22;
        color: white;
        padding: 0.6rem 1.2rem;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 0.3rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    button[type="submit"]:hover {
        background-color: #e96500;
    }

    .error {
        color: #d84200;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .success {
        background-color: #ff7a22; 
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 0.3rem;
        text-align: center;
        margin: 1rem auto;
        max-width: 30rem;
        box-shadow: 0 2px 8px rgba(255, 122, 34, 0.35);
    }

    .pickup-link {
        margin-top: 1rem;
        text-align: center;
        font-size: 0.95rem;
        color: #ff7a22;
    }

    .pickup-link a {
        color: #ff5e00;
        font-weight: bold;
        text-decoration: none;
        border-bottom: 2px solid #ff5e00;
        padding-bottom: 2px;
        transition: 0.2s;
    }

    .pickup-link a:hover {
        color: #d84f00;
        border-bottom-color: #d84f00;
    }
</style>

@if(session()->has('success'))
    <div class="success">
        {{ session('success') }}
    </div>
@endif

<h2>Request Access</h2>

<form method="POST" action="{{ route('request.access.submit') }}">
    @csrf

    <div>
        <label for="device_type">Device Type</label>
        <select name="device_type" id="device_type">
            <option value="">-- Select device type --</option>
            <option value="Laptop" {{ old('device_type') == 'Laptop' ? 'selected' : '' }}>Laptop</option>
            <option value="Desktop" {{ old('device_type') == 'Desktop' ? 'selected' : '' }}>Desktop</option>
            <option value="Phone" {{ old('device_type') == 'Phone' ? 'selected' : '' }}>Phone</option>
            <option value="Tablet" {{ old('device_type') == 'Tablet' ? 'selected' : '' }}>Tablet</option>
            <option value="Other" {{ old('device_type') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('device_type')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="device_os">Operating System</label>
        <select name="device_os" id="device_os">
            <option value="">-- Select operating system --</option>
            <option value="Windows" {{ old('device_os') == 'Windows' ? 'selected' : '' }}>Windows</option>
            <option value="Linux" {{ old('device_os') == 'Linux' ? 'selected' : '' }}>Linux</option>
            <option value="macOS" {{ old('device_os') == 'macOS' ? 'selected' : '' }}>macOS</option>
            <option value="Android" {{ old('device_os') == 'Android' ? 'selected' : '' }}>Android</option>
            <option value="iOS" {{ old('device_os') == 'iOS' ? 'selected' : '' }}>iOS</option>
            <option value="ChromeOS" {{ old('device_os') == 'ChromeOS' ? 'selected' : '' }}>ChromeOS</option>
            <option value="Solaris" {{ old('device_os') == 'Solaris' ? 'selected' : '' }}>Solaris</option>
            <option value="MS-DOS" {{ old('device_os') == 'MS-DOS' ? 'selected' : '' }}>MS-DOS</option>
            <option value="Other" {{ old('device_os') == 'Other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('device_os')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="your@email.com">
        @error('email')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="note">Note</label>
        <textarea name="note" id="note" placeholder="Why do you need access? 100 characters max">{{ old('note') }}</textarea>
        @error('note')
            <p class="error">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <button type="submit">Submit Request</button>
    </div>
    <p class="status-link">
        To check status, go to - 
        <a href="http://127.0.0.1:8000/pickup" target="_blank">Check Request Status</a>
    </p>
</form>
