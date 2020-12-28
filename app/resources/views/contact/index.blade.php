<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} @if($header ?? '') | {{ $header ?? '' }}@endif</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    @if(!is_null($favicon = Admin::favicon()))
    <link rel="shortcut icon" href="{{$favicon}}">
    @endif

    {!! Admin::css() !!}

    <script src="{{ Admin::jQuery() }}"></script>
    {!! Admin::headerJs() !!}
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="hold-transition {{config('admin.skin')}} {{join(' ', config('admin.layout'))}}">

@if($alert = config('admin.top_alert'))
    <div style="text-align: center;padding: 5px;font-size: 12px;background-color: #ffffd5;color: #ff0000;">
        {!! $alert !!}
    </div>
@endif

<div class="wrapper">

    @include('admin::partials.header')

    @include('admin::partials.sidebar')

    <div class="content-wrapper" id="pjax-container">
        {!! Admin::style() !!}
        <div id="app">
            <section class="content-header">
                <h1>
                    {!! $header ?? '' ?? '' ?: trans($title) !!}
                    <small>{!! $description ?? '' ?: trans('admin.description') !!}</small>
                </h1>

            </section>

            <section class="content">
                <div class="box grid-box">
                    <form method="POST" action="{{ route('contact.confirm') }}" class="form-horizontal">
                        @csrf
                        <div class="box-body">
                            <div class="fields-group">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email" class="col-sm-2 asterisk control-label">メールアドレス</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                                <input
                                                    name="email"
                                                    value="{{ old('email') }}"
                                                    type="text"
                                                    class="form-control">
                                                @if ($errors->has('email'))
                                                    <p class="error-message">{{ $errors->first('email') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 asterisk control-label">お名前</label>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="fa fa-pencil fa-fw"></i></span>
                                                <input
                                                    name="name"
                                                    value="{{ old('name') }}"
                                                    type="text"
                                                    class="form-control">
                                                @if ($errors->has('name'))
                                                    <p class="error-message">{{ $errors->first('name') }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="col-sm-2 asterisk control-label">お問い合わせ内容</label>
                                        <div class="col-sm-8">
                                             <textarea name="body" class="form-control text">{{ old('body') }}</textarea>
                                                @if ($errors->has('body'))
                                                    <p class="error-message">{{ $errors->first('body') }}</p>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="box-footer">
                            <div class="col-md-12">
                                <div class="btn-group pull-right">
                                    <button type="submit" class="btn btn-info pull-right">入力内容確認</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
        </div>
        {!! Admin::script() !!}
        {!! Admin::html() !!}
    </div>

    @include('admin::partials.footer')

</div>

<button id="totop" title="Go to top" style="display: none;"><i class="fa fa-chevron-up"></i></button>

<script>
    function LA() {}
    LA.token = "{{ csrf_token() }}";
    LA.user = @json($_user_ ?? '');
</script>

<!-- REQUIRED JS SCRIPTS -->
{!! Admin::js() !!}

</body>
</html>
