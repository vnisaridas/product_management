@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-end mb-3">
        
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Create Product') }}</div>
                <div class="card-body">
                    <form method="post" action="{{ route('update_product') }}">
                      @csrf  
                      <input type="hidden" name="id" value="{{ $obj->id }}">
                      <div class="form-group mb-3">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required value="{{ $obj->title }}">
                      </div>
                      <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description">{{ $obj->description }}</textarea>
                      </div>
                      <div class="form-group mb-3">
                            <label for="image">Image</label>
                            <input type="file" class="form-control" id="image" accept="image/*">
                            <input type="hidden" name="image_name" id="image_name" value="{{ $obj->image }}">
                            <img alt="" id="preview_image" src="{{ asset('storage/products/thumbnail/'.$obj->image) }}" class="mt-3" width="150">
                      </div>
                      <div class="form-group mb-3">
                        <table class="table table-bordered">
                            <tr>
                                <td width="30%">Size</td>
                                <td>
                                    <select name="size[]" class="form-control" multiple="multiple">
                                        @if($obj->product_attributes)
                                            @foreach($obj->product_attributes as $attributes)
                                                @if($attributes->name == 'size')
                                                    @if($attributes->attributes)
                                                        @foreach($attributes->attributes as $attr)
                                                            <option selected="selected" value="{{ $attr->id }}">{{ $attr->value }}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach    
                                        @endif
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Color</td>
                                <td><select name="color[]" class="form-control" multiple="multiple">
                                    @if($obj->product_attributes)
                                            @foreach($obj->product_attributes as $attributes)
                                                @if($attributes->name == 'color')
                                                    @if($attributes->attributes)
                                                        @foreach($attributes->attributes as $attr)
                                                            <option selected="selected" value="{{ $attr->id }}">{{ $attr->value }}</option>
                                                        @endforeach
                                                    @endif
                                                @endif
                                            @endforeach    
                                        @endif
                                </select></td>
                            </tr>
                        </table>
                      </div>
                      <div class="form-group">
                            <div class="d-flex justify-content-end">
                                <a class="btn btn-danger btn-sm mx-2 px-3" href="{{ route('products') }}">Back</a>
                                <button class="btn btn-sm btn-primary text-white px-3" type="submit">Save</button>
                            </div>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script type="text/javascript">
    $('#image').change(function(){
        $('.background-black').show();
        var formData = new FormData();
        var file = $('#image')[0].files[0];
        formData.append('image', file);
        formData.append('_token',"{{ csrf_token() }}");
        $.ajax({ 
            url: '{{ route('store_image') }}',
            type: 'POST',
            data: formData,
            dataType:'json',
            success: function (data) {
              $('#image_name').val(data.filename);
              $('#preview_image').attr('src',data.image_url);
              $('#preview_image').removeClass('d-none');
              $('.background-black').hide();
            },
            error: function (data) {
              
            },
            cache: false,
            contentType: false,
            processData: false
          });
    });
    $('select[name="size[]"]').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        width:"100%"
    });
    $('select[name="color[]"]').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        width:"100%"
    });
</script>
@endpush