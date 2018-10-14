@extends('home.layouts.app')

@section('title', '注册')

@section('content')

    <div class="six wide column">
        <div class="ui stacked segment">
            <div class="content">
                <h2>注册新用户</h2>

                <div class="ui divider"></div>

                @include('common.error')

                <form class="ui form" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <div class="field {{ $errors->has('username') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="username" placeholder="用户名" value="{{ old('username') }}" required="">
                        </div>
                        @if ($errors->has('username'))
                            <div class="ui error message">
                                <strong>{{ $errors->first('username') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="field {{ $errors->has('email') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="envelope icon"></i>
                            <input type="text" name="email" placeholder="邮箱" value="{{ old('email') }}" required="">
                        </div>
                        @if ($errors->has('email'))
                            <div class="ui error message">
                                <strong>{{ $errors->first('email') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="field {{ $errors->has('password') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="密码" value="" required="">
                        </div>
                        @if ($errors->has('password'))
                            <div class="ui error message">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="password" name="password_confirmation" placeholder="确认密码" value="" required="">
                        </div>
                    </div>
                    <div class="field {{ $errors->has('captcha') ? 'error' : '' }}">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input type="text" name="captcha" placeholder="验证码" value="" required="" autocomplete="off">
                        </div>
                        @if ($errors->has('captcha'))
                            <div class="ui error message">
                                <strong>{{ $errors->first('captcha') }}</strong>
                            </div>
                        @endif
                    </div>
                    <div class="field">
                        <div class="ui large label">
                            <img class="thumbnail captcha" src="{{ captcha_src('flat') }}" onclick="this.src='/captcha/flat?'+Math.random()" title="点击图片重新获取验证码">
                        </div>
                    </div>

                    <div class="ui buttons fluid">
                        <button class="ui teal button" type="submit"><i class="save icon"></i>立即注册</button>
                    </div>
                </form>


                <div class="ui horizontal divider">Or</div>

                <div class="ui warning message">
                    推荐使用 GitHub 登录！
                </div>

                {{--<a class="ui basic teal button fluid" href="{{ route('oauth.github') }}"><i class="icon github alternate"></i> Github 登录</a>--}}

            </div>
        </div>
    </div>

@stop