{{-- a view to be included when there are form validation ,it will higlight any form input if has form--}}
{{-- this is left to the end of the current stage , as this requires to be applied internally for each form not centerlized.
@if(count($errors) > 0)
    <script>
        var errorKeys = JSON.parse('<?=json_encode($errors->keys())?>');

        $.each( errorKeys, function( key, value ) {

            $("input[name="+value+"]").css('border-color', 'red');
            $("select[name="+value+"]").css('border-color', 'red');
            $("textarea[name="+value+"]").css('border-color', 'red');

        });
    </script>
@endif
--}}