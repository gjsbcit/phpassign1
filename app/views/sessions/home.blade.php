@extends('layouts/basic')

@section('maincontent')
    <div class = "jumbotron">
        <h1>Logged in as {{$user}}</h1>
        {{link_to_route('logout', 'Logout')}}
    </div>
    <div class="row">
        @if(!isset($notes))
            {{Form::open(['route'=>'home.store', 'files' => true])}}
            <div class="col-md-3">
                <h3>Notes</h3>
                {{Form::textarea('note', null, ['size' => '15x35'])}}
            </div>
            <div class="col-md-3">
                <h3>Links</h3>
                @for($i = 0; $i < 4; $i++)
                    {{Form::text('link[]')}}
                @endfor
            </div>
            <div class="col-md-3">
                <h3>Images</h3>
                <h4>Click for full size</h4>
                {{Form::file('image')}}
            </div>
            <div class="col-md-3">
                <h3>TBD</h3>
                {{Form::textarea('tbd', null, ['size' => '15x35'])}}
            </div>
        @else
            {{Form::model($notes, array('route' => array('home.update', $notes->id), 'method' => 'PUT', 'files' => true))}}
            <div>
                <div class="col-md-3">
                    <h3>Notes</h3>
                    {{Form::textarea('note', $notes->note, ['size' => '15x35'])}}
                </div>
                <div class="col-md-3">
                    <h3>Links</h3>
                    @foreach (unserialize($notes->link) as $link)
                        @if($link != "")
                            <input name="link[]" type="text" value="{{$link}}" onclick="openLink('{{$link}}');">
                        @endif
                    @endforeach
                    @for($i = 0; $i < 4; $i++)
                        {{Form::text('link[]', "")}}
                    @endfor
                </div>
                <div class="col-md-3">
                    <h3>Images</h3>
                    <h4>Click for full size</h4>
                    @if($count == 4)
                        <p>Maximum number of images reached : 4</p>
                    @else
                        {{Form::file('image')}}
                    @endif
                    <br/>
                        @foreach($images as $image)
                            <ul>
                                <li>
                                    @if($image->ext == 'jpg')
                                        <img src="data:image/jpg;base64,{{base64_encode($image->image)}}" style="width:150px;height:150px;"
                                             onclick="Popup('{{base64_encode($image->image)}}')">
                                    @else
                                        <img src="data:image/gif;base64,{{base64_encode($image->image)}}" style="width:150px;height:150px;"
                                             onclick="Popup('{{base64_encode($image->image)}}')">
                                    @endif
                                    {{Form::checkbox('delete[]', $image->id)}} delete
                                </li>
                            </ul>
                        <br/>
                        @endforeach
                </div>
                <div class="col-md-3">
                    <h3>TBD</h3>
                    {{Form::textarea('tbd', $notes->tbd, ['size' => '15x35'])}}
                </div>
            </div>
        @endif
    </div>
    <div class="row vertical-center-row">
        <div class="text-center col-md-4 col-md-offset-4">
            {{ Form::hidden('user', $user) }}
            {{Form::submit('Save')}}
        </div>
    </div>
    {{Form::close()}}

@stop