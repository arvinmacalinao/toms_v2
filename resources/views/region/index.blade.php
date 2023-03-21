@extends('layouts.content')
@section('content')
<div class="content">
    @if(strlen($msg) > 0)
    <div class="alert alert-info alert-dismissible fade show" role="alert">
          {{ $msg }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="content clearfix">
                            <form class="row row-cols-lg-auto g-2 align-items-center" method="GET" action="{{ url()->current() }}">
                                @csrf
                                <div class="col-auto">
                                    <input class="form-control" type="text" placeholder="Search..." name="qsearch" id="qsearch" maxlength="255" value="{{ old('search', $search) }}">
                                </div>
                                <div class="col-auto">
                                    <input class="btn btn-info btn-sm" type="submit" name="search-btn" id="search-btn" value="Search">
                                </div>
                            </form>
                            <div class="container-fluid">
                                <div class="pull-right pr-2">
                                    <a class="btn btn-primary btn-sm" href="{{ route('region.new') }}" title="{{ $data['page'] }}"><i class="fa fa-plus"> </i> Add {{ $data['page'] }}</a>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th>#</th>
                                    <th>Region Name</th>
                                    <th>Region Code</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                    @php
								    	$ctr = $rows->firstItem();
								    @endphp
                                    @foreach ($rows as $row)
                                      <tr>
                                         <td>{{ $ctr }}</td>
                                         <td>{{ $row->rg_name }}</td>
                                         <td>{{ $row->rg_short }}</td>
                                         <td>
                                            <a href="{{ route('region.edit', ['id' => $row->rg_id]) }}" title="Update"><i class="fa fa-edit fa-lg" style="color:rgb(5, 141, 0)"></i></a>
                                            <a href="{{ route('region.delete', ['id' => $row->rg_id]) }}" title="Delete" onclick="return confirm('Are you sure you want to delete this data?')"><i class="fa fa-window-close-o fa-lg" style="color:rgb(141, 0, 0)"></i></a>
                                         </td>
                                      </tr>
                                    @php
                                        $ctr++
                                    @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end">
                                @include('subviews.pagination', ['rows' => $rows])
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection