<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<style>
    nav {
        padding: 3px;
        background-color: #eff5f5;
        color: #bfbfbf;
        text-align: center;
    }
    .container {
        width: 70%;
        margin: 0 auto;
        text-align: center;
    }
    p {
        margin-bottom: 30px;
        color: #737373;
        text-align: justify;
    }
    .reset {
        display: inline-block;
        padding: 10px;
        border-radius: 5px;
        background-color: #3399ff;
        color: #fff;
        text-decoration: none;
    }
    .link {
        font-size: 12px;
    }
    .link a {
        color: #3366ff;
    }
    footer {
        padding: 4px;
        background-color: #eff5f5;
        color: #bfbfbf;
    }
    footer p {
        text-align: center;
    }
</style>
<body>
    <div id="mail">
        <nav>
            <h3 class="text-center p-4">SCM BulletinBoard</h3>
        </nav>
        <main class="container">
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <a href="{{ $url }}" class="reset">Reset Password</a>
            <p>If you did not request a password reset, no further action is required.</p>

            <hr>
            <p class="link">
                If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:
                <a href="{{ $url }}">{{ $url }}</a>
            </p>
        </main>
        <footer>
            <p>Seattle Consulting Myanmar Co.,Ltd</p>
        </footer>
    </div>
</body>
</html>
