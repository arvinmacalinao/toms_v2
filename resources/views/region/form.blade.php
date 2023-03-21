@extends('layouts.content')
@section('content')
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="content clearfix">
                            <div class="col-lg-8 col-md-7">
                                @if($id == 0)
                                    <h4 class="title">Add {{ $data['page'] }}</h4>
                                @else
                                    <h4 class="title">Edit {{ $data['page'] }}</h4>
                                @endif
                            </div>
                            <div class="content">
                                <form method="POST" action="{{ route('region.save', ['id' => $id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="rg_name">Region Name <span class="text-danger">*</span></label>
                                                <input placeholder="Region Name" class="form-control border-input @error('rg_name') is-invalid @enderror" type="text" maxlength="255" name="rg_name" id="rg_name" value="{{ old('rg_name', $region->rg_name) }}" required="required">
					                            <div class="invalid-feedback">@error('rg_name') {{ $errors->first('rg_name') }} @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="rg_short">Region Code <span class="text-danger">*</span></label>
                                                <input placeholder="Region Code" class="form-control border-input @error('rg_short') is-invalid @enderror" type="text" maxlength="255" name="rg_short" id="rg_short" value="{{ old('rg_short', $region->rg_short) }}" required="required">
					                            <div class="invalid-feedback">@error('rg_short') {{ $errors->first('rg_short') }} @enderror</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <input class="btn btn-primary pull-right" type="submit" name="form-submit" id="form-submit" value="Save">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection