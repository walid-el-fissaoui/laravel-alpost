@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <p>{{__('messages.welcome')}}</p>
                    <p>{{__('messages.example_with_value' , ['name' => 'walid'])}}</p>
                    <p>@lang('messages.welcome')</p>
                    <p>@lang('messages.example_with_value', ['name' => 'ahmed'])</p>
                    <p>{{trans_choice('messages.plural',0)}}</p>
                    <p>{{trans_choice('messages.plural',1)}}</p>
                    <p>{{trans_choice('messages.plural',2)}}</p>
                    <hr class="bg-light"/>
                    <p>{{__('welcome')}}</p>
                    <p>{{__('example_with_value' , ['name' => 'khalid'])}}</p>
                    <p>{{trans_choice('plural',0)}}</p>
                    <p>{{trans_choice('plural',1)}}</p>
                    <p>{{trans_choice('plural',2)}}</p>
                    @can('secret.page')
                    <p><a href="{{route('secret')}}">administration</a></p>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
