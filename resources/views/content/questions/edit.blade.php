@extends('layouts/layoutMaster')

@section('title', 'Question Create')

@section('content')
    <h4 class="py-3 mb-0">
        <span class="text-muted fw-light">Master Panel /</span><span class="fw-medium"> Edit Question</span>
    </h4>

    <div class="app-ecommerce">

        <!-- Add question -->
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">

            <div class="d-flex flex-column justify-content-center">
                <h4 class="mb-1 mt-3">Edit Question</h4>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form class="form form-vertical form-repeater"
                            action="{{ route('update-question', $question->id) }}" method="POST" id="question_form"
                            enctype="multipart/form-data">
                            @csrf

                            <div id="questions_container">
                                <div class="question_list row p-1 mt-4">
                                    <div class="col-6">
                                        <input type="text" name="question" placeholder="Enter Question"
                                            class="form-control" value="{{ $question->question }}">
                                    </div>
                                    <div class="col-1">
                                        <input type="number" class="form-control option-input" name="marks"
                                            placeholder="Marks" value="{{ $question->marks }}">
                                    </div>
                                    <div class="col-3">
                                        <input type="text" class="form-control option-input" placeholder="Enter Option">
                                    </div>
                                    <div class="col-2">
                                        <button type="button" class="add_option btn btn-primary">Add Option</button>
                                    </div>
                                    <div class="col-6 mt-2">
                                        <input type="file" name="images" class="form-control" multiple>
                                    </div>
                                    <div class="options_list">
                                        @foreach ($question->options as $option)
                                            <div class="option mt-2 flex row rounded">
                                                <div class="col-1 text-end">
                                                    <input type="radio" name="selected" value="{{ $option->option }}"
                                                        {{ $option->id == $question->right_id ? 'checked' : '' }}>
                                                    <input type="hidden" name="options[]" value="{{ $option->option }}">
                                                </div>
                                                <div class="col-6">
                                                    {{ $option->option }}
                                                </div>
                                                <div class="col-1">
                                                    <button class="remove_option mx-5 btn-sm btn-danger">X</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-success float-end">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Basic Horizontal form layout section end -->
    @endsection

    @section('vendor-script')
        <!-- vendor files -->
        <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
    @endsection

    @section('page-script')
        <!-- Page js files -->
        <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(document).ready(function() {
                var questionCount = 0;

                // Function to add option to a question
                $(document).on("click", ".add_option", function() {
                    var optionInput = $(this).parent().prev().children(".option-input");
                    var option = optionInput.val();

                    // Check if option is not empty and not duplicate
                    if (option !== "" && !$(".options_list").find('input[value="' +
                            option + '"]').length) {
                        var optionHTML = `
            <div class="option mt-2 flex row rounded">
                <div class="col-1 text-end">
                    <input type="radio" name="selected" value="${option}">
                    <input type="hidden" name="options[]" value="${option}">
                </div>
                <div class="col-6">
                    ${option}
                </div>
                <div class="col-1">
                    <button class="remove_option mx-5 btn-sm btn-danger">X</button>
                </div>
            </div>
            `;
                        $(".options_list").append(optionHTML);
                        optionInput.val(""); // Clear input field after adding option
                    } else {
                        alert("Option cannot be empty or duplicate.");
                    }
                });

                // Function to remove an option
                $(document).on("click", ".remove_option", function() {
                    $(this).closest('.option').remove();
                });


                // Form submission
                $("#question_form").submit(function(event) {
                    event.preventDefault();

                    // check validation single question
                    var question = $(this).find("input[name='question']").val();
                    var marks = $(this).find("input[name='marks']").val();
                    var options = $(this).find(".options_list").children().length;

                    if ($(this).find("input[name='selected']:checked").length == 0) {
                        alert("Please select the right option");
                        return;
                    }

                    if (question === "" || marks === "" || options === 0) {
                        alert("Question, Marks and Options are required");
                        return;
                    }

                    this.submit();
                });
            });
        </script>
    @endsection
