@extends('home.layouts.app')

@section('title', '修改资料')

@section('content')
    <div class="ui ten wide column">

        <div class="ui stacked segment">
            <div class="content">
                <h2>修改资料</h2>

                <div class="ui divider"></div>

                @include('common.error')

                <form class="ui form" role="form" method="POST" action="{{ route('users.update', $user->id) }}" required="" accept-charset="UTF-8" enctype="multipart/form-data">
                    {{ method_field('PUT') }}
                    {{ csrf_field() }}

                    <div class="required field">
                        <label for="name-field">用户名（唯一标识，请谨慎修改）</label>
                        <input class="form-control" type="text" name="username" id="username-field" value="{{ $user->username }}" required="">
                    </div>

                    <div class="required field">
                        <label for="name-field">邮箱（登录标识）</label>
                        <input class="form-control" type="email" name="email" id="email-field" value="{{ $user->email }}" required="">
                    </div>

                    <div class="field">
                        <label for="real_name-field">称呼</label>
                        <input class="form-control" type="text" name="name" id="name-field" value="{{ $user->name }}" required="">
                    </div>

                    {{--<div class="field">--}}
                        {{--<label for="company-field">所在公司</label>--}}
                        {{--<input class="form-control" type="text" name="company" id="company-field" value="">--}}
                    {{--</div>--}}

                    {{--<div class="field">--}}
                        {{--<label for="website-field">个人网站</label>--}}
                        {{--<input class="form-control" type="text" name="website" id="website-field" value="">--}}
                    {{--</div>--}}

                    {{--<div class="field">--}}
                        {{--<label for="city-field">所在城市</label>--}}
                        {{--<input class="form-control" type="text" name="city" id="city-field" value="beijing">--}}
                    {{--</div>--}}

                    <div class="field">
                        <label for="bio-field">个人简介</label>
                        <textarea rows="3" name="introduction" id="introduction-field" placeholder=""> {{ $user->introduction }} </textarea>
                    </div>

                    <div class="field">
                        <label for="avatar-field">头像</label>
                        <input type="file" name="avatar" id="avatar-field">
                        <br>
                        <div class="upload-image-preview">
                            <img class="ui small image spaced rounded bordered" src="{{ $user->avatar }}">
                            <img class="ui tiny image spaced rounded bordered" src="{{ $user->avatar }}">
                            <img class="ui mini image spaced rounded bordered" src="{{ $user->avatar }}">
                        </div>
                    </div>

                    <button class="ui primary labeled icon button" type="submit">
                        <i class="save icon"></i> 保存
                    </button>
                </form>

            </div>
        </div>
    </div>
@stop