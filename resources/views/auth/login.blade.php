@extends('home.layouts.app')

@section('title', '登录')

@section('content')

    <div class="six wide column">
        <div class="ui stacked segment">
            <div class="content">
                <h2>邮箱登录</h2>

                <div class="ui divider"></div>

                @include('common.error')

                <form class="ui form" role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

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
                        <div class="ui left icon action input">
                            <i class="lock icon"></i>
                            <input type="password" name="password" placeholder="密码" value="" required="">
                            <a class="ui button basic light" href="{{ route('password.request') }}">
                                忘记密码？
                            </a>
                        </div>
                        @if ($errors->has('password'))
                            <div class="ui error message">
                                <strong>{{ $errors->first('password') }}</strong>
                            </div>
                        @endif
                    </div>

                    <div class="ui buttons fluid">
                        <button class="ui blue button" type="submit"><i class="send icon"></i>登录</button>
                        <div class="or"></div>
                        <a class="ui button" href="{{ route('register') }}">注册</a>
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