<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Mini Transaksi App</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="{{ asset('skydash/vendors/feather/feather.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/css/vendor.bundle.base.css') }}">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('skydash/vendors/ti-icons/css/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('skydash/js/select.dataTables.min.css') }}">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('skydash/css/vertical-layout-light/style.css') }}">
    <!-- endinject -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.2.0/dist/select2-bootstrap-5-theme.min.css" />
    @stack('style')
    <style>
        .btn {
            height: 38px;
            border-radius: 0.25rem;
        }

        .form-control {
            height: 38px;
        }

        .modal .modal-dialog {
            margin-top: 1.75rem;
        }

        .card {
            border-radius: 0.5rem;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #9e9e9e21 !important;
        }

        .table td {
            white-space: unset;
        }

        table td {
            line-height: 1.5 !important;
        }

        .navbar {
            box-shadow: none !important;
        }

        /* style.css */

        .loading-indicator {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.8);
            justify-content: center;
            align-items: center;
            font-size: 24px;
            z-index: 1000;
        }

        .dropdown-toggle::after {
            display: none !important;
        }

        .btn-group.dropup .dropdown-menu {
            left: 50%;
            transform: translateX(-50%);
        }
    </style>

    <script language="javascript">
        function getkey(e) {
            if (window.event)
                return window.event.keyCode;
            else if (e)
                return e.which;
            else
                return null;
        }

        function goodchars(e, goods, field) {
            var key, keychar;
            key = getkey(e);
            if (key == null) return true;

            keychar = String.fromCharCode(key);
            keychar = keychar.toLowerCase();
            goods = goods.toLowerCase();

            // check goodkeys
            if (goods.indexOf(keychar) != -1)
                return true;
            // control keys
            if (key == null || key == 0 || key == 8 || key == 9 || key == 27)
                return true;

            if (key == 13) {
                var i;
                for (i = 0; i < field.form.elements.length; i++)
                    if (field == field.form.elements[i])
                        break;
                i = (i + 1) % field.form.elements.length;
                field.form.elements[i].focus();
                return false;
            };
            // else return false
            return false;
        }
    </script>
</head>

<body style="background: white;">
    <div class="loading-indicator" id="loadingIndicator">
        Loading...
    </div>
    <div class="container-scroller bg-white">
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
            <div class="container-fluid container">
                <a class="navbar-brand" href="#">
                    {{ DB::table('profil_usahas')->value('nama_usaha') }}
                </a>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ url('logout') }}">
                            Logout <i class="bi bi-arrow-right"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-bottom border-top">
            <div class="container-fluid container">
                <a style="text-decoration: none;" class="text-center mt-1 mb-0" href="{{ url('dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <p class="mb-0">Home</p>
                </a>
                <div class="btn-group dropup">
                    <a style="text-decoration: none;" href="#" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="text-center mt-1 mb-0">
                            <i class="bi bi-gear"></i><br>
                            <p class="mb-0">Setting</p>
                        </div>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- Dropdown menu links -->
                        <li><a class="dropdown-item border-bottom" href="{{ url('user') }}"><i class="bi bi-person"></i> Users</a></li>
                        <li><a class="dropdown-item border-bottom" href="{{ url('biaya') }}"><i class="bi bi-coin"></i> Daftar Harga</a></li>
                        <li><a class="dropdown-item" href="{{ url('profil-usaha') }}"><i class="bi bi-building"></i> Profil Usaha</a></li>
                    </ul>
                </div>
                <a style="text-decoration: none;" class="text-center mt-1 mb-0" href="{{ url('transaksi') }}">
                    <i class="bi bi-repeat"></i>
                    <p class="mb-0">Transaksi</p>
                </a>
            </div>
        </nav>
        <div class="container-fluid page-body-wrapper" style="background: #F5F7FF;">
            <!-- partial -->
            <div class="main-panel" style="width: 100% !important;">

                <div
                    style="
                    background: #4b49ac;
                    background-image:  
                    url('https://cdn.pixabay.com/photo/2022/08/05/07/06/background-7366180_1280.jpg'); 
                    height: 200px; 
                    background-position: center;
                    background-size: cover;
                    width: 100%;">

                </div>
                <div class="content-wrapper px-4 mb-5 container">
                    @yield('content')
                </div>
                <!-- content-wrapper ends -->
                <!-- partial:partials/_footer.html -->
                {{-- <footer class="mb-5 footer container">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    </div>
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Developed by <a href="https://porkaone.com">Nabil Putra</a> <br>
                            <a href="https://nabilchen96.github.io/jasa-pembuatan-website/"><i>sahredev {{ date('Y') }}</i></a>
                        </span>
                    </div>
                </footer> --}}
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <!-- plugins:js -->

    <script src="{{ asset('skydash/vendors/js/vendor.bundle.base.js') }}"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->

    <script src="{{ asset('skydash/vendors/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('skydash/vendors/datatables.net/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('skydash/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('skydash/js/dataTables.select.min.js') }}"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('skydash/js/off-canvas.js') }}"></script>
    <script src="{{ asset('skydash/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('skydash/js/template.js') }}"></script>
    <script src="{{ asset('skydash/js/settings.js') }}"></script>
    <script src="{{ asset('skydash/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('skydash/js/dashboard.js') }}"></script>
    <script src="{{ asset('skydash/js/Chart.roundedBarCharts.js') }}"></script>
    <script src="https://unpkg.com/axios@0.27.2/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.15.7/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    <!-- script tambahan  -->

    <!-- End custom js for this page
        -->
    @stack('script')

    <script>
        // script.js

        // Function to show the loading indicator
        function showLoadingIndicator() {
            document.getElementById('loadingIndicator').style.display = 'flex';
        }

        // Function to hide the loading indicator
        function hideLoadingIndicator() {
            document.getElementById('loadingIndicator').style.display = 'none';
        }

        // Event listener for popstate
        window.addEventListener('popstate', function(event) {
            // Show the loading indicator when navigating back
            showLoadingIndicator();

            // You may want to add additional logic here if needed
        });

        // Event listener for pageshow
        window.addEventListener('pageshow', function(event) {
            // Check if the page is being shown from the bfcache (back-forward cache)
            if (event.persisted) {
                // If it's a back-forward navigation, hide the loading indicator
                hideLoadingIndicator();
            }
        });
    </script>
</body>

</html>
