<script>
    $(document).ready(function () {
        $('#newsletter-form').on('submit', function (e) {
            e.preventDefault();

            let form = $(this);
            let email = form.find('input[name="email"]').val();
            let button = $('#subscribe-btn');
            let message = $('#subscribe-message');

            // UI: disable button + show spinner
            button.prop('disabled', true);
            button.find('.btn-text').text('Subscribing...');
            button.find('.spinner').removeClass('hidden');

            $.ajax({
                url: "{{ route('subscribe.ajax') }}",
                method: "POST",
                data: {
                    email: email,
                    _token: "{{ csrf_token() }}"
                },
                success: function (response) {
                    message.text(response.message).removeClass('text-red-500').addClass('text-green-600');

                    // Reset form
                    form.trigger("reset");
                },
                error: function (xhr) {
                    let errorMessage = 'An error occurred.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    message.text(errorMessage).removeClass('text-green-600').addClass('text-red-500');
                },
                complete: function () {
                    // UI: reset button
                    button.prop('disabled', false);
                    button.find('.btn-text').text('');
                    button.find('.spinner').addClass('hidden');
                }
            });
        });
    });
</script>
