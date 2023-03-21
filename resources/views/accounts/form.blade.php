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
                                <form method="POST" action="{{ route('account.save', ['id' => $id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_fname">First Name <span class="text-danger">*</span></label>
                                                <input placeholder="First Name" class="form-control border-input @error('u_fname') is-invalid @enderror" type="text" maxlength="255" name="u_fname" id="u_fname" value="{{ old('u_fname', $user->u_fname) }}" required="required">
					                            <div class="invalid-feedback">@error('u_fname') {{ $errors->first('u_fname') }} @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_mname">Middle Name <span class="text-danger">*</span></label>
                                                <input placeholder="Middle Name" class="form-control border-input @error('u_mname') is-invalid @enderror" type="text" maxlength="255" name="u_mname" id="u_mname" value="{{ old('u_mname', $user->u_mname) }}" required="required">
					                            <div class="invalid-feedback">@error('u_mname') {{ $errors->first('u_mname') }} @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_lname">Last Name <span class="text-danger">*</span></label>
                                                <input placeholder="Last Name" class="form-control border-input @error('u_lname') is-invalid @enderror" type="text" maxlength="255" name="u_lname" id="u_lname" value="{{ old('u_lname', $user->u_lname) }}" required="required">
					                            <div class="invalid-feedback">@error('u_lname') {{ $errors->first('u_lname') }} @enderror</div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_suffix">Suffix</label>
                                                <input placeholder="Suffix" class="form-control border-input @error('u_suffix') is-invalid @enderror" type="text" maxlength="255" name="u_suffix" id="u_suffix" value="{{ old('u_suffix', $user->u_suffix) }}">
					                            <div class="invalid-feedback">@error('u_suffix') {{ $errors->first('u_suffix') }} @enderror</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_username">Username<span class="text-danger">*</span></label>
					                            <input placeholder="Username" autocomplete="disabled" class="form-control @error('u_username') is-invalid @enderror" type="text" maxlength="255" name="u_username" id="u_username" value="{{ old('u_username', $user->u_username) }}" required="required">
					                            <div class="invalid-feedback">@error('u_username') {{ $errors->first('u_username') }} @enderror</div>
                                             </div>
                                        </div>
                                        @if($id == 0)
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_password">Password<span class="text-danger">*</span></label>
                                                <input placeholder="Password" autocomplete="false" class="form-control @error('u_password') is-invalid @enderror" type="password" maxlength="255" name="u_password" id="u_password" value="">
                                                <div class="invalid-feedback">@error('u_password') {{ $errors->first('u_password') }} @enderror</div>
                                             </div>
                                        </div>
                                        @endif
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_position">Designation<span class="text-danger">*</span></label>
                                                <input placeholder="Designation" class="form-control @error('u_position') is-invalid @enderror" type="text" maxlength="255" name="u_position" id="u_position" value="{{ old('u_position', $user->u_position) }}" required="required">
                                                <div class="invalid-feedback">@error('u_position') {{ $errors->first('u_position') }} @enderror</div>
                                             </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_gender">Sex<span class="text-danger">*</span></label>
                                                    <div class="container-fluid">
                                                        <div class="row">
                                                            <div class="col-md-3 mr-4">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input m-2" type="radio" id="u_gender" name="u_gender" value="1" {{ old('u_gender', $user->u_gender) == 1 ? 'checked' : '' }} required="required">
                                                                    <label class="form-check-label" for="u_gender">Male</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input m-2" type="radio" id="u_gender" name="u_gender" value="0" {{ old('u_gender', $user->u_gender) == 0 ? 'checked' : '' }} required="required">
                                                                    <label class="form-check-label" for="u_gender">Female</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>         
                                             </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="u_username">Region<span class="text-danger">*</span></label>
					                            <select class="form-control p-1 @error('rg_id') is-invalid @enderror" name="rg_id" id="rg_id">
                                                    @foreach($regions as $region)
                                                        <option value="{{ $region->rg_id }}" {{ old('rg_id', $user->rg_id) == $region->rg_id ? 'selected' : '' }}>{{ $region->rg_name }}</option>
                                                        
                                                    @endforeach
					                            </select>					
					                            <div class="invalid-feedback">@error('rg_id') {{ $errors->first('rg_id') }} @enderror</div>
                                             </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="r_id">Role<span class="text-danger">*</span></label>
					                            <select class="form-control p-1 @error('r_id') is-invalid @enderror" name="r_id" id="r_id">
                                                    @foreach($roles as $role)
                                                        <option value="{{ $role->r_id }}" {{ old('r_id', $user->r_id) == $role->r_id ? 'selected' : '' }}>{{ $role->r_name }}</option>
                                                        
                                                    @endforeach
					                            </select>					
					                            <div class="invalid-feedback">@error('rg_id') {{ $errors->first('rg_id') }} @enderror</div>
                                             </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="form-label" for="is_active">Status<span class="text-danger">*</span></label>
					                            <select class="form-control p-1 @error('is_active') is-invalid @enderror" name="is_active" id="is_active">
                                                    <option value="1"> Active</option>
                                                    <option value="0"> Inactive</option>
					                            </select>					
					                            <div class="invalid-feedback">@error('is_active') {{ $errors->first('is_active') }} @enderror</div>
                                             </div>
                                        </div>
                                        <div class="col-md-3">
                                            
                                                <label class="form-label" for="u_signature">Signature</label>
                                                <input class="form-control-file @error('u_signature') is-invalid @enderror" type="file" id="u_signature" name="u_signature">
                                                <div class="invalid-feedback">@error('u_signature') {{ $errors->first('u_signature') }} @enderror</div>
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