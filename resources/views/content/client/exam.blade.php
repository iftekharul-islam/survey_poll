@php
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Home')

@section('content')
    <div class="container mt-5">
        <h3>
            Exam Question
        </h3>
        <div class="row">
            <form class="form form-vertical" action="{{ route('exam.submit') }}" method="POST" id="info_form">
                @csrf

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
                            <label class="form-label
                        fw-bold"
                                for="name">{{ $index + 1 . '.' . $item->question->question }}</label>
                            <input type="hidden" class="form-control" id="name"
                                name="questionlist[{{ $index }}][id]" value="{{ $item->id }}">
                        </div>
                        <div class="mb-1">
                            @foreach ($item->question->options as $option)
                                <input type="radio" name="questionlist[{{ $index }}][selected]"
                                    value="{{ $option->id }}">
                                <label for="option1">{{ $option->option }}</label>
                            @endforeach
                        </div>
                    </div>
                @endforeach


                <div class="col-12 mt-2">
                    <button type="submit" class="btn btn-success">Submit</button>
                </div>
            </form>
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
