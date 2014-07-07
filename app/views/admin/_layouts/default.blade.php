<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Reportula - Bareos & Bacula Backups Web Gui">
        <meta name="author" content="Pedro Oliveira">
        <title>Reportula - Bacula Backups Web Gui </title>
        
        <?php echo Asset::styles(); ?>
        <?php echo Asset::scripts(); ?>

    </head>
    <body>
        <div class="container-fluid">
            @if ( Sentry::check() )
                <!-- Navbar -->
                <style>
                    @section('styles')
                        body {
                            padding-top: 60px;
                        }
                    @show
                </style>
                 <!-- navbar -->
                <div class="navbar navbar-fixed-top">
                    <div class="navbar-inner">
                        <div class="container">
                            <a class="brand" href="{{ URL::route('admin.dashboard') }}"><img src={{asset('assets/img/logo.png')}} alt="Logo" > Reportula</a>
                                <ul class="nav">
                                    <li><a href="{{ URL::route('admin.dashboard') }}"><i class="icon-fam-application-view-list"></i> Dashboard</a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('admin.users') }}"><i class="icon-fam-user"></i> Users</a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('admin.groups') }}"><i class="icon-fam-group-add"></i> Groups</a></li>
                                    <li>
                                        <a href="{{ URL::route('admin.settings') }}"><i class="icon-fam-cog"></i> Settings</a>
                                    </li>
                                    <li>
                                        <a href="{{ URL::route('admin.configurator') }}"><i class="icon-fam-wrench"></i> Configurator</a></li> 
                                    </li>
                                </ul>
                                <ul class="pull-right nav">
                                    </li>
                                    <li><a href="{{ URL::route('admin.logout') }}"><i class="icon-fam-house-link"></i> Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ./ navbar -->
            @endif
                 @yield('main')
            <hr>
            <footer>
                <p><center>Reportula V2.0.5 <?php echo HTML::link('http://www.reportula.org', 'wwww.reportula.org'); ?> &copy; Pedro Oliveira 2013 - 2014 </center></p>
            </footer>

        </div>
    </body>
</html>


  

   