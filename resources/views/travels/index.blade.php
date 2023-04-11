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
                            <form class="row row-cols-lg-auto g-2 align-items-center" method="POST" action="{{ url()->current() }}">
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
                                    
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead class="thead-dark">
                                    <th class="text-left">#</th>
                                    @if(Auth::user()->r_id == 1)
                                    <th>Region</th>
                                    @endif
                                    <th>Created by</th>
                                    <th>Destination</th>
                                    <th class="text-nowrap">Purpose</th>
                                    <th>Employee/s</th>
                                    <th>Date of Travel</th>
                                    <th>Date/Time Created</th>
                                    <th>Date/Time Updated</th>
                                    <th>Status</th>
                                    <th>Comment/s</th>
                                    <th><a class="btn btn-primary btn-sm" href="" title="{{ $data['page'] }}"><i class="fa fa-plus"> </i> Add {{ $data['page'] }}</a></th>
                                </thead>
                                <tbody>
                                    @php
								    	$ctr = $rows->firstItem();
								    @endphp
                                    @foreach ($rows as $row)
                                    <tr>
                                        <td class="text-left text-nowrap">{{ $ctr }}
                                            <span class="fa fa-user text-warning"  title="Created by {{ create_initials($row->user->u_fname, $row->user->u_mname, $row->user->u_lname) }}"></span>
                                        </td>
                                        @if(Auth::user()->r_id == 1) 
                                                <td class="text-nowrap">{!! $row->user->region->rg_name !!}</td>
                                        @endif
                                        <td class="text-nowrap">{!! $row->user->u_lname !!}, {!! $row->user->u_fname !!}</td>
                                        <td class="text-break">{!! $row->t_destination !!}</td>
                                        <td class="text-break">{!! nl2br($row->t_purpose) !!}</td>
                                        <td class="text-center">{{ count($row->passengers) }}</td>
                                        <td class="text-nowrap">{!! $row->t_start_date == $row->t_end_date ? format_date($row->t_start_date) : format_date($row->t_start_date)."<br>".format_date($row->t_end_date) !!}</td>
                                        <td class="text-nowrap text-center">{{ get_date_diff($row->created_at) }}</td>
                                        <td class="text-nowrap text-center">{{ get_date_diff($row->updated_at) }}</td>
                                        <td class="text-nowrap text-center">
                                            @if(Auth::user()->r_id == '8' || Auth::user()->r_id == '2')
                                                    <div>RD: @if($row->t_rd == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_rd == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times text-danger" title="Disapproved"></span> @endif</div>
                                                    <div>Verified: @if($row->is_verified == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->is_verified == 1) <span class="fa fa-check text-success" title="Approved"></span> @elseif($row->is_verified == 2) <span class="fa fa-times text-danger" title="Disapproved"></span> @else <span class="fa fa-check text-warning" title="Approved (OIC)"></span> @endif</div>
                                                    <div>USEC: @if($row->t_usec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_usec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times fa-lg text-danger" title="Disapproved"></span> @endif</div>
                                                @elseif(Auth::user()->r_id == '1')
                                                    @if($row->user->r_id == '8' || $row->user->r_id == '2')
                                                        <div>RD: @if($row->t_rd == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_rd == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times text-danger" title="Disapproved"></span> @endif</div>
                                                        <div>Verified: @if($row->is_verified == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->is_verified == 1) <span class="fa fa-check text-success" title="Approved"></span> @elseif($row->is_verified == 2) <span class="fa fa-times text-danger" title="Disapproved"></span> @else <span class="fa fa-check text-warning" title="Approved (OIC)"></span> @endif</div>
                                                        <div>USEC: @if($row->t_usec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_usec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times fa-lg text-danger" title="Disapproved"></span> @endif</div>
                                                    @else
                                                        <div>Verified: @if($row->is_verified == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->is_verified == 1) <span class="fa fa-check text-success" title="Approved"></span> @elseif($row->is_verified == 2) <span class="fa fa-times text-danger" title="Disapproved"></span> @else <span class="fa fa-check text-warning" title="Approved (OIC)"></span> @endif</div>
                                                        <div>USEC: @if($row->t_usec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_usec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times text-danger" title="Disapproved"></span> @endif</div>
                                                        <div>SEC: @if($row->t_sec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_sec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times fa-lg text-danger" title="Disapproved"></span> @endif</div>
                                                    @endif
                                                @else
                                                    <div>Verified: @if($row->is_verified == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->is_verified == 1) <span class="fa fa-check text-success" title="Approved"></span> @elseif($row->is_verified == 2) <span class="fa fa-times text-danger" title="Disapproved"></span> @else <span class="fa fa-check text-warning" title="Approved (OIC)"></span> @endif</div>
                                                    <div>USEC: @if($row->t_usec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_usec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times text-danger" title="Disapproved"></span> @endif</div>
                                                    <div>SEC: @if($row->t_sec == 0) <span class="fa fa-exclamation text-warning" title="Pending"></span> @elseif($row->t_sec == 1) <span class="fa fa-check text-success" title="Approved"></span> @else <span class="fa fa-times fa-lg text-danger" title="Disapproved"></span> @endif</div>
                                            @endif
                                        </td>
                                        <th class="text-center text-info">@if(count($row->unread) != 0){!! count($row->unread) !!} <span class="fa fa-comment fa-sm" title="{!! count($row->unread) !!} comment/s"></span>@endif</th>
                                            <td class="text-right text-nowrap">
                                            @if(Auth::user()->r_id == 8)
                                                <a href="{{ url('pdf/'.$row->t_id) }}" target="_blank"><button class="btn btn-success btn-sm" type="button" title="Print"><i class="fa fa-print fa-sm"></i></button></a>
                                            @else
                                                @if(Auth::user()->r_id == 1)
                                                    <a href="{{ url('pdf/admin/'.$row->t_id) }}" target="_blank"><button class="btn btn-success btn-sm" type="button" title="Print"><i class="fa fa-print fa-sm"></i></button></a>
                                                    <a href="{{ url('travels/view/'.$row->t_id) }}"><button class="btn btn-primary btn-sm" type="button" title="View"><i class="fa fa-eye fa-sm"></i></button></a>
                                                @else
                                                    @if(Auth::user()->r_id == 8)
                                                        <a href="{{ url('pdf/'.$row->t_id) }}" target="_blank"><button class="btn btn-success btn-sm" type="button" title="Print"><i class="fa fa-print fa-sm"></i></button></a>
                                                    @else
                                                        @if($row->is_verified != 3)
                                                            <a href="{{ url('pdf/'.$row->t_id) }}" target="_blank"><button class="btn btn-success btn-sm" type="button" title="Print"><i class="fa fa-print fa-sm"></i></button></a>
                                                        @endif
                                                    @endif
                                                    <a href="{{ url('travels/view/'.$row->t_id) }}"><button class="btn btn-primary btn-sm" type="button" title="View"><i class="fa fa-eye fa-lg"></i></button></a>
                                                    @if($row->u_id == Auth::user()->u_id)
                                                        <a href="{{ url('travels/update/'.$row->t_id) }}"><button class="btn btn-info btn-simple btn-xs" type="button" title="Update"><i class="fa fa-edit fa-lg"></i></button></a>
                                                        <a href="{{ url('travels/cancel/'.$row->t_id) }}" onclick="return confirm('Are you sure?')"><button class="btn btn-danger btn-simple btn-xs" type="button" title="Cancel"><i class="fa fa-ban fa-sm"></i></button></a>
                                                    @else
                                                        <a href="{{ url('travels/tag/'.$row->t_id) }}" onclick="return confirm('Are you sure?')"><button class="btn btn-warning btn-simple btn-xs" type="button" title="Remove Tag"><i class="fa fa-tag fa-sm"></i></button></a>
                                                    @endif
                                                @endif
                                            @endif
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