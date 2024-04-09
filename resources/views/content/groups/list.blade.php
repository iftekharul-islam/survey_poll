@extends('layouts/layoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">
                    <a href="/question-add" class="float-end">
                      <button type="button" class="btn btn-success">
                        + Question
                      </button>
                    </a>
                </div>
              @if(count($groups) > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Associated Country</th>
                                <th>Associated Question</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($groups as $item)
                                <tr>
                                    <td>{{ $item->group['name'] }}</td>
                                    <td>{{ $item->country->name }}</td>
                                    <td>{{ $item->question_count }}</td>
                                    <td>
                                        {{-- <a class="" href="/order/{{ $order->id }}">
                                            <i data-feather="eye" class="me-50"></i>
                                        </a> --}}
                                        <a class="" href="{{ '/group-questions/' . $item->group_id. '/'. $item->country_id }}">
                                            <button class="btn btn-primary">Associate</button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
              @else
                <div class="card-body">
                  <div class="alert alert-danger" role="alert">
                        No Questions available
                    </h4>
                </div>
              @endif
            </div>
        </div>
    </div>
    <!-- Hoverable rows end -->
@endsection

@section('vendor-script')
    <!-- vendor js files -->
    <script src="{{ asset(mix('vendors/js/pagination/jquery.bootpag.min.js')) }}"></script>
    <script src="{{ asset(mix('vendors/js/pagination/jquery.twbsPagination.min.js')) }}"></script>
@endsection
@section('page-script')
    {{-- Page js files --}}
    <script src="{{ asset(mix('js/scripts/pagination/components-pagination.js')) }}"></script>
@endsection
