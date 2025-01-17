@extends('layouts/layoutMaster')

@section('title', 'Question Create')

@section('content')
  <h4 class="py-3 mb-0">
    <span class="text-muted fw-light">Master Panel /</span><span class="fw-medium"> Add Question</span>
  </h4>

  <div class="app-ecommerce">

    <!-- Add question -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">

      <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1 mt-3">Add a new Question</h4>
        <p class="text-muted">Question placed across your clients</p>
      </div>

    </div>
        <div class="row">
          <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form class="form form-vertical form-repeater" action="{{ route('store-question') }}" method="POST" id="question_form"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="country_select">Country</label>
                                    <div class="col">
                                        <select class="select2 form-select" id="country_select" name="country_id">
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="topic_select">Group</label>
                                    <select class="select2 form-select" id="topic_select" name="group_id">
                                        @foreach ($groups as $group)
                                            <option value="{{ $group['id'] }}">{{ $group['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div id="questions_container">
                            <!-- Dynamic questions and options will be added here -->
                        </div>

                        <div class="col-12 border-top mt-2">
                            <button type="button" id="add_question" class="btn btn-primary me-1 mt-2">+ Question</button>
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

            $("#add_question").click(function() {
                var questionHTML = `
              <div class="question_list row p-1 border-top mt-4">
              <div class="col-12 mb-3">
                  <label>Question ${questionCount +1}</label>
                    <button type="button" class="remove_question btn-group-sm btn-danger float-end">X</button>
              </div>
              <div class="col-6">
                  <input type="text" name="questions[${questionCount}][question]" placeholder="Enter Question" class="form-control">
                  </div>
                  <div class="col-1">
                  <input type="number" class="form-control option-input" name="questions[${questionCount}][points]" min="1" placeholder="Points">
              </div>
              <div class="col-3">
              <input type="text" class="form-control option-input" placeholder="Enter Option">
              </div>
              <div class="col-2">
                <button type="button" class="add_option btn btn-primary">Add Option</button>
                </div>
                <div class="col-6 mt-2">
                <input type="file" name="questions[${questionCount}][images][]" class="form-control" multiple>
                </div>
                <div class="options_list"></div>
              </div>
                `;
                $("#questions_container").append(questionHTML);
                questionCount++;
            });

            // Function to add option to a question
            $(document).on("click", ".add_option", function() {
                var optionInput = $(this).parent().prev().children(".option-input");
                var option = optionInput.val();
                // get id of closest question_list tag
                var questionIndex = $(this).parent().parent().index();
                console.log("🚀 ~ $ ~ questionIndex:", questionIndex)
                // var questionIndex = $(this).closest('.question_list').index();

                // Check if option is not empty and not duplicate
                if (option !== "" && !$(this).parent().siblings(".options_list").find('input[value="' +
                        option + '"]').length) {
                    var optionHTML = `
            <div class="option mt-2 flex row rounded">
                <div class="col-1 text-end">
                    <input type="radio" name="questions[${questionIndex}][selected]" value="${option}">
                    <input type="hidden" name="questions[${questionIndex}][options][]" value="${option}">
                </div>
                <div class="col-6">
                    ${option}
                </div>
                <div class="col-1">
                    <button class="remove_option mx-5 btn-sm btn-danger">X</button>
                </div>
            </div>
            `;
                    $(this).parent().siblings(".options_list").append(optionHTML);
                    optionInput.val(""); // Clear input field after adding option
                } else {
                    // Display error message for duplicate or empty option
                    alert("Option cannot be empty or duplicate.");
                }
            });

            // Function to remove an option
            $(document).on("click", ".remove_option", function() {
                $(this).closest('.option').remove();
            });

            // Function to remove a question
            $(document).on("click", ".remove_question", function() {
                $(this).closest(".question_list").remove();
            });

            // Form submission
            $("#question_form").submit(function(event) {
                event.preventDefault();

                // validate form
                // check if all questions have options
                var allQuestionsHaveOptions = true;
                $(".question_list").each(function() {
                    if ($(this).find(".options_list").children().length === 0) {
                        allQuestionsHaveOptions = false;
                    }
                });

                if (!allQuestionsHaveOptions) {
                    alert("All questions must have options");
                    return;
                }

                // check if all questions have selected options
                var allQuestionsHaveSelectedOptions = true;
                $(".question_list").each(function() {
                    if ($(this).find('input[name^="questions["][name$="[selected]"]:checked')
                        .length === 0) {
                        allQuestionsHaveSelectedOptions = false;
                    }
                });

                if (!allQuestionsHaveSelectedOptions) {
                    alert("All questions must have selected options");
                    return;
                }

                // check if all questions have marks

                var allQuestionsHaveMarks = true;
                $(".question_list").each(function() {
                    if ($(this).find('input[name^="questions["][name$="[mark]"]').val() === "") {
                        allQuestionsHaveMarks = false;
                    }
                });

                if (!allQuestionsHaveMarks) {
                    alert("All questions must have marks");
                    return;
                }

                // submit form by ajax
                var formData = new FormData(this);
                $.ajax({
                    url: $(this).attr("action"),
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        alert("Question created successfully");
                        window.location.href = "/question";
                    },
                    error: function(error) {
                        alert("An error occurred. Please try again");
                    },
                    cache: false,
                    contentType: false,
                    processData: false
                });
            });
        });
    </script>
@endsection
