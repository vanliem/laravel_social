@if(count($errors))
    <div class="alert alert-warning">
        <strong>You have {{ count($errors->all()) }} error: </strong>
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session()->has('flash_message'))
    <div class="alert alert-{{ session('flash_message_type') }}">
        <p>{{ session()->get('flash_message') }}</p>
    </div>
@endif