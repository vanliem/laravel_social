@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Account Setting</div>

                    <div class="panel-body">
                        <div class="col-md-6 col-md-offset-3">
                            @include('includes.message-block')
                            {!! Form::open(array('route' => 'account.edit', 'files' => true)) !!}
                            <div class="form-group">
                                {!! Form::label('first_name') !!}
                                {!! Form::text('first_name', $user->first_name, array('class' => 'form-control', 'id' => 'first_name')) !!}
                            </div>
                            <div class="form-group">
                                {!! Form::label('Image') !!}
                                {!! Form::file('image', ['class' => 'form-control', 'id' => 'image']) !!}
                            </div>
                            {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                            @if(Storage::disk('local')->has($user->first_name . '-' . $user->id . '.jpg'))
                                <section class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <img src="{{ route('account.image', ['file_name' => $user->first_name . '-' . $user->id . '.jpg']) }}" alt="" class="img-responsive">
                                    </div>
                                </section>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
