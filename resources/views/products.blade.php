@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-primary btn-sm text-white" href="{{ route('create_product') }}">Create Product</a>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Image</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        @if(!empty($data) && $data->count())
                        <tbody>
                            @foreach($data as $key => $value)
                                <tr>
                                    <td>{{ $value->title }}</td>
                                    <td>{{ substr($value->description,0,50) }}..</td>
                                    <td><img alt="" src="{{ asset('storage/products/thumbnail/'.$value->image) }}" width="50"></td>
                                    <td>
                                        <a class="btn btn-sm btn-warning" href="{{ route('edit_product',[$value->id]) }}">Update</a> | <a class="btn btn-sm btn-danger" href="{{ route('delete_product',[$value->id]) }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">There are no data.</td>
                            </tr>
                        </tbody>
                        @endif
                    </table>

                    {!! $data->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
