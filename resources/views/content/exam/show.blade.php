@extends('layouts/layoutMaster')

@section('title', 'User List')

@section('content')
    <div class="container mt-5">
        <h3>
            Exam Result
            <br />
            Total Marks: {{ $exam->final_score }}/{{ $exam->total_score }}
        </h3>
        <div class="row">
            @foreach ($exam->questions as $index => $item)
                <div class="border rounded mb-1 p-2">
                    <div class="mb-1">
                        @if ($item->question->images)
                            @foreach ($item->question->images as $image)
                                <img src="{{ asset('storage/images/' . $image->image) }}" alt="question image"
                                    class="img-fluid" style="max-height: 200px; max-width: 200px;">
                            @endforeach
                        @endif
                    </div>
                    <div class="mb-1">
                        <label class="form-label fw-bold" for="name">{{ $index + 1 . '.' . $item->question->question }}
                            ({{ $item->question->points }})</label>
                    </div>
                    <div class="mb-1">
                        @foreach ($item->question->options as $index => $option)
                            <br />
                            <label for="option1"
                                class="{{ $item->right_id == $option->id ? 'text-success' : '' }}">{{ $index + 1 . '.' . $option->option }}
                                @if ($item->answer_id == $option->id)
                                    @if ($item->answer_id == $item->right_id)
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check"
                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 12l5 5l10 -10" />
                                        </svg>
                                    @elseif ($item->answer_id === null)
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="icon icon-tabler icon-tabler-x text-danger" width="24" height="24"
                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                            stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <line x1="18" y1="6" x2="6" y2="18" />
                                            <line x1="6" y1="6" x2="18" y2="18" />
                                        </svg>
                                        <strong class="text-danger">Not answered</strong>
                                @else
                                      <svg xmlns="http://www.w3.org/2000/svg"
                                           class="icon icon-tabler icon-tabler-x text-danger" width="24" height="24"
                                           viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                           stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <line x1="18" y1="6" x2="6" y2="18" />
                                        <line x1="6" y1="6" x2="18" y2="18" />
                                      </svg>
                                @endif
                            </label>
                            <br />
                        @endforeach
                    </div>
                </div>
            @endforeach

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
