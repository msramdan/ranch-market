@extends('layouts.app')

@section('title', __('Edit Provinces'))

@section('content')
        <div class="page-body">
                <div class="container-fluid">
                    <div class="page-header" style="margin-top: 5px">
                        <div class="row">
                            <div class="col-sm-6">
                                <h3>{{ __('Provinces') }}</h3>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item">
                                        <a href="/">{{ __('Dashboard') }}</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('provinces.index') }}">{{ __('Provinces') }}</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">
                                        {{ __('Edit') }}
                                    </li>
                                </ol>
                            </div>
                            <div class="col-sm-6">
                            </div>
                        </div>
                    </div>
                </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('provinces.update', $province->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                @include('provinces.include.form')

                                <a href="{{ url()->previous() }}" class="btn btn-secondary">{{ __('Back') }}</a>

                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
