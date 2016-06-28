@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <section class="row new-post">
                        <div class="col-md-6 col-md-offset-3">

                            @include('includes.message-block')

                            <header> <h3>What do you have to say !!?</h3> </header>
                            {!! Form::open(array('route' => 'post.create')) !!}
                            <div class="form-group {{ $errors->has('body') ? 'has-error' : '' }}">
                                {!! Form::textarea('body', old('body'), array('class' => 'form-group', 'id' => 'new-post', 'cols' => '50', 'rows' => '5', 'placeholder' => 'Your Post')) !!}
                            </div>
                            {!! Form::submit('Create Post', array('class' => 'btn btn-primary')) !!}
                            {!! Form::close() !!}
                        </div>
                    </section>
                    <section class="row posts">
                        <div class="col-md-6 col-md-offset-3">
                            @if(count($posts))
                                <header><h3> What other people say....</h3> </header>
                                @foreach($posts as $post)
                                    <article class="post">
                                        <p class="post-{{ $post->id }}">{{ $post->body }}</p>
                                        <div class="info">
                                            Posted by {{ $post->user->first_name }} on {{ $post->created_at }}
                                        </div>
                                        <div class="interaction">
                                            <a href="javascript:void(0)" class="like" data-id="{{ $post->id }}">{{ (Auth::user()->likes()->where('post_id', $post->id)->first() && Auth::user()->likes()->where('post_id', $post->id)->first()->like) ? 'Dislike' : 'Like'}}</a>
                                            @if(Auth::user() == $post->user)
                                                <a href="javascript:void(0)" class="edit-post" data-id="{{ $post->id }}">Edit</a> |
                                                <a href="{{ route('post.delete', ['post' => $post->id]) }}" onclick="return window.confirm('Do you want to delete this post ?')">Delete</a>
                                            @endif
                                        </div>
                                    </article>
                                @endforeach
                            @endif
                        </div>
                    </section>
                    <div class="modal fade" tabindex="-1" role="dialog" id="edit-post-modal">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Update Post</h4>
                                </div>
                                <div class="modal-body">
                                    <form action="">
                                        <input type="hidden" class="hidden-post-id">
                                        <label for="post-body-modal"></label>
                                        <textarea autofocus class="form-control" name="post-body-modal" id="post-body-modal" rows="5"></textarea>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                    <button type="button" class="btn btn-primary" id="save-post-modal">Update</button>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
