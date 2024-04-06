@extends('layouts/layoutMaster')

@section('title', 'User List')

@section('content')
    <div class="row" id="table-hover-row">
        <div class="col-12">
            <div class="card">
                <div class="card-body d-flex justify-content-between">

                    <a href="/question-add"><button type="button" class="btn btn-gradient-primary">Add New
                            Question</button></a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Question</th>
                                <th>Country</th>
                                <th>Topic</th>
                                <th>Marks</th>
                                <th>Options</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr>
                                    <td>
                                        <span class="fw-bold">{{ $question->id }}</span>
                                    </td>
                                    <td>{{ $question->question }}</td>
                                    <td>{{ $question->country->name }}</td>
                                    <td>{{ $question->topic->name }}</td>
                                    <td>{{ $question->marks }}</td>
                                    <td>{{ count($question->options) }} Options <br />
                                        Answer: {{ $question->answer->option }}
                                    </td>
                                    <td>
                                        {{-- <a class="" href="/order/{{ $order->id }}">
                                            <i data-feather="eye" class="me-50"></i>
                                        </a> --}}
                                        {{-- <a class="" href="#">
                                            <i data-feather="edit-2" class="me-50"></i>
                                        </a>
                                        <a class="" href="#">
                                            <i data-feather="trash" class="me-50"></i>
                                        </a> --}}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mx-1 d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mt-2">
                                <li class="page-item prev"><a class="page-link"
                                        style="pointer-events: {{ $questions->currentPage() == 1 ? 'none' : '' }}"
                                        href="{{ $questions->url($questions->currentPage() - 1) }}">
                                        {{ '<' }}
                                    </a>
                                </li>
                                @for ($i = 1; $i <= $questions->lastPage(); $i++)
                                    <li class="page-item {{ $i == $questions->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $questions->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                                <li class="page-item next" disabled><a class="page-link"
                                        style="pointer-events: {{ $questions->currentPage() == $questions->lastPage() ? 'none' : '' }}"
                                        href="{{ $questions->url($questions->currentPage() + 1) }}">{{ '>' }}</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
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
