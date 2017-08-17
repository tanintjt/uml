<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{!! config('app.name') !!}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <p>Dear <b>{{ ucfirst($user->name) }}</b>,</p>

            <p>Thank you for signing up with “<b>Uttara Motors Smart Service</b>”, the leading automobile company in Bangladesh.</p>

            <p>Your account id is {{ $user->email }}.</p>
            <p>Please <a href="{!! route('auth.activation', $activation->token) !!}" class="btn btn-xs btn-success">click here</a> to complete the registration process.</p>
            <p>Feel free to contact us at any time.</p>
            <p>Thank you.<br/>
                Yours sincerely,</p>
            <p>Customer Care Team</p>

            <address>
                Email: <a href="mailto:support@ugc-bd.net">support@ugc-bd.net</a><br>
                <abbr title="Phone">Phone:</abbr> +88 02 8170902<br>
                <a href="http://www.uttaramotorsltd.com.bd" target="_blank">www.uttaramotorsltd.com.bd</a>
            </address>
            <p><small>You received this email because you signed up in “<b>Uttara Motors Smart Service</b>” from <cite title="Google Play Store">Google Play Store</cite>.</small></p>

        </div>
    </div>

</div>
</body>
</html>