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
                                <form method="POST" action="{{ route('setting.save', ['id' => $id]) }}" enctype="multipart/form-data">
                                    
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="s_region_name">Setting Region Name <span class="text-danger">*</span></label>
                                                <input placeholder="Setting Region Name" class="form-control border-input @error('s_region_name') is-invalid @enderror" type="text" maxlength="255" name="s_region_name" id="s_region_name" value="{{ old('s_region_name', $setting->s_region_name) }}" required="required">
					                            <div class="invalid-feedback">@error('s_region_name') {{ $errors->first('s_region_name') }} @enderror</div>
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