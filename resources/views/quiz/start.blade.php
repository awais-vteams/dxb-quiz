<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Quiz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div id="quiz-container">
                        <h2 id="question-text" class="mb-4"></h2>
                        <div id="options-container" class="mb-6"></div>

                        <x-primary-button id="skip-question" type="button">Skip</x-primary-button>
                        <x-primary-button id="submit-answer" type="button">Next</x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            fetchQuestion();

            $('#skip-question').click(function () {
                skipQuestion();
            });

            $('#submit-answer').click(function () {
                submitAnswer();
            });
        });

        function fetchQuestion() {
            $.get('{{ route('quiz.question') }}')
                .done(function (response) {
                    if (!response.question) {
                        window.location.href = '{{ route('quiz.result') }}';
                        return;
                    }

                    $('#question-text').html(`<strong>Question (${response.index}/${response.total}):</strong> ` + response.question.title);
                    let optionsHtml = '';

                    $.each(response.question.answers, function (index, option) {
                        optionsHtml += '<label class="mb-4"><input type="radio" name="option" value="' + option.id + '" class="mr-2">' + option.title + '</label><br>';
                    });

                    $('#options-container').html(optionsHtml);
                    $('#quiz-container').data('question-id', response.question.id);
                })
                .fail(function (error) {
                    console.error('Error fetching question:', error);
                });
        }

        function submitAnswer() {
            let selectedOption = $('input[name="option"]:checked').val();

            if (!selectedOption) {
                alert('Please select an option.');
                return;
            }

            const questionId = $('#quiz-container').data('question-id');

            $.ajax({
                type: "POST",
                url: '{{ route('quiz.submit') }}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    question_id: questionId,
                    answer_id: selectedOption
                },
                success: function (msg) {
                    fetchQuestion();
                }
            });
        }

        function skipQuestion() {
            const questionId = $('#quiz-container').data('question-id');

            $.ajax({
                type: "POST",
                url: '{{ route('quiz.skip') }}',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                data: {
                    question_id: questionId,
                },
                success: function (msg) {
                    fetchQuestion();
                }
            });
        }
    </script>
</x-app-layout>
