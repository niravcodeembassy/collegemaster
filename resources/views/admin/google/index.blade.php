@extends('admin.layouts.app')

@section('content')
    <div class="row d-flex mb-2">
        <div class="d-flex justify-content-between align-items-center col">
            <h4>{{ $title }}</h4>
            <div>
                <a href="{{ route('admin.google.insert') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-plus"></i> Insert All Products
                </a>
                <a href="{{ route('admin.google.delete') }}" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Delete All Products
                </a>
            </div>
        </div>
    </div>
@endsection
