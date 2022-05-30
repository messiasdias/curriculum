<head>
    <meta charset="utf-8" />
    <title>SPEEL SOLAR - CMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Speel Solar - Cms dashborad" name="description" />
    <meta content="Themesdesign" name="author" />

    <!-- App favicon -->
    <!-- <link rel="shortcut icon" href="{{ asset('public/assets/images/favicon.ico') }}"> -->
    <link rel="icon" type="image/png" href="https://yata2.lss.locawebcorp.com.br/d3b25f1cfffc72769c5e0c686dbf003105a4941765f621fdc8a96630ac598a8a">

    <!-- Bootstrap Css -->
    <link href="{{ asset("{$public_path}admin/css/bootstrap.min.css") }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset("{$public_path}admin/css/icons.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset("{$public_path}admin/css/app.min.css") }}" id="app-style" rel="stylesheet" type="text/css" />
    <!-- Custom Css -->
    <link href="{{ asset("{$public_path}admin/css/custom.css") }}" rel="stylesheet" type="text/css" />
  
    <!-- Google fonts -->
    <script src="https://maps.google.com/maps/api/js?key=AIzaSyCtSAR45TFgZjOs4nBFFZnII-6mMHLfSYI"></script>

    <!-- Parse php variables -->
    <script>
        var cmsApiBaseUrl = "{{ asset('/api/') }}";
        var assets = "{{ !empty($public_path) ? asset($public_path) . '/'  : '' }}"
    </script>
</head>