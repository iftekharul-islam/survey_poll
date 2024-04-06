@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <h3>
            Exam Result
            <br />
            Total Marks: {{ $exam->final_score }}
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
                            ({{ $item->question->marks }})</label>
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
                                @endif
                            </label>
                            <br />
                        @endforeach
                    </div>
                </div>
            @endforeach

        </div>
    </div>
@endsection


@section('page-script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#country_select').on('change', function() {
                var country_id = $(this).val();
                $.ajax({
                    url: "{{ route('client.topics') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $html = '<option value="">Please Select a Topic</option>';
                        response.forEach(element => {
                            $html += '<option value="' + element.id + '">' + element
                                .name + '</option>';
                        });
                        response?.length > 0 ? $('#topic_select').html($html) : $(
                            '#topic_select').html(
                            '<option value="">No Topic Found</option>');
                    }
                });
            });

            $('#topic_select').on('change', function() {
                var topic_id = $(this).val();
                var country_id = $('#country_select').val();

                $.ajax({
                    url: "{{ route('client.questions.range') }}",
                    type: "POST",
                    data: {
                        country_id: country_id,
                        topic_id: topic_id,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        $html = '<option value="">Please Select a Range</option>';
                        for (let index = 0; index < response; index = index + 10) {
                            $html += '<option value="' + (response <
                                    index +
                                    10 ? response : index + 10) + '">' + '1 - ' + (response <
                                    index +
                                    10 ? response : index + 10) +
                                '</option>';
                        }
                        $('#question_count').html($html);
                    }
                });
            });
            $("#info_form").submit(function(event) {
                event.preventDefault();
                // validate the form
                var name = $('#name').val();
                var email = $('#email').val();
                var country_id = $('#country_select').val();
                var topic_id = $('#topic_select').val();
                var question_count = $('#question_count').val();

                if (name == '' || email == '' || country_id == '' || topic_id == '' || question_count ==
                    '') {
                    alert('Please fill all the fields');
                    return;
                }

                this.submit();
            });
        })
    </script>
@endsection
