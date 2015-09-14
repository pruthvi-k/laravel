<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
</head>
<body>

<header> </header>
@inject('audit', 'Focalworks\Audit\Audit')
<div class="sidebar"> @include('audit::sidebar',['contentTypes' => $audit->getContentTypesList() ]) </div>
<div class="container">
    <div class="contents"> @yield('content') </div>
</div>
<footer>  </footer>
</body>
</html>
