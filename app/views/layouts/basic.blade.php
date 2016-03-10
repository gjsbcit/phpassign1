<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css">
    <script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
    @yield('pagetitle')
    @yield('headers')
    <style>
        li {
            list-style-type: none;
        }
    </style>
    <script>
        function Popup(data) {

            var mywindow = window.open('', 'Picture', 'height=1200,width=800');
            mywindow.document.write('<!DOCTYPE HTML>');
            mywindow.document.write('<html>');
            mywindow.document.write('<body><img src="data:image/gif;base64,' + data + '"></body>');
            mywindow.document.write('</html>');

            mywindow.print();
            mywindow.close();

            return true;
        }
    </script>
</head>
    <body>
        <div class="container">
                @include('flash::message')
                @yield('maincontent')
                @yield('footers')
        </div>

        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>

        <script>$('#flash-overlay-modal').modal()</script>
        <script>
            function openLink(link) {
                window.open(link);
            }
        </script>
    </body>
</html>

