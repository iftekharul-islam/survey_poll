@extends('layouts/layoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
              @if(count($exams) > 0)
              <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Details</th>
                                <th>Country</th>
                                <th>Marks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($exams as $exam)
                                <tr>

                                    <td>
                                        <a href="/exam-view/{{ $exam->id }}">
                                            <span class="fw-bold">{{ $exam->id }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $exam->name }} <br />{{ $exam->email }}</td>
                                    <td>{{ $exam->country->name }}</td>
                                    <td>{{ $exam->final_score ?? '~' }}/{{ $exam->total_score }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $exams->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $exams->url($exams->currentPage() - 1) }}">
                                        {{ '<' }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $exams->lastPage(); $i++)
                                    <li class="page-item {{ $i == $exams->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $exams->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $exams->currentPage() == $exams->lastPage() ? 'none' : '' }}"
                                        href="{{ $exams->url($exams->currentPage() + 1) }}">{{ '>' }}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
              @else
                <div class="card-body">
                  <div class="alert alert-danger" role="alert">
                    No Exams found!
                  </div>
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
