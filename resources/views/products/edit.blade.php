<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
</head>
<body>
    @extends('layouts.app')

    @section('content')
    <main class="col-md-9 col-lg-10">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 pb-3 border-bottom">
            <h2>Edit Product</h2>

            <div class="btn-toolbar mb-2 mb-md-0">
                <div class="btn-group me-2 ">
                    <a href="{{ route('products.index') }}" type="button" class="btn btn-sm btn-outline-secondary">Back</a>
                </div>
            </div>
        </div>

        @include('layouts.messages')

        <!-- Product Creation Form -->
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Product <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" disabled>
                <small class="form-text text-muted">Can't change product name. Any changes will affect existing orders.</small>
            </div>

            <div class="row mb-3">
                <div class="col md-6">
                    <label for="price" class="form-label">Price <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="price" id="price" value="{{ old('price') ? number_format((float)old('price'), 2, ',', '.') : '' }}" required>
                    <small class="form-text text-muted">Input product sell price. <br>Ex.: 39,99</small>
                    <br>
                    <small class="form-text text-danger">Changes to this field WILL NOT affect existing orders.</small>
                </div>
                
                <div class="col md-6">
                    <label for="cost" class="form-label">Cost <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="cost" id="cost" value="{{ old('cost') ? number_format((float)old('cost'), 2, ',', '.') : '' }}" required>
                    <small class="form-text text-muted">Input product base cost. <br>Ex.: 19,99</small>
                    <br>
                    <small class="form-text text-danger">Changes to this field WILL NOT affect existing orders.</small>
                </div>
            </div>

            <div class="mt-3">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
    </main>
    @endsection
</body>
</html>