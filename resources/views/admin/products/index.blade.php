@extends('admin.layout.app')
@section('content')
    <div class="layout-wrapper">

        <!-- header -->
        <div class="header">
            <div class="menu-toggle-btn">
                <!-- Menu close button for mobile devices -->
                <a href="#">
                    <i class="bi bi-list"></i>
                </a>
            </div>
            <!-- Logo -->
            <a href="rpss-dashboard.html" class="logo">
                <img src="{{ asset('public/admin_a/assets/images/tz_logo.png') }}" alt="logo">
            </a>
            <!-- ./ Logo -->
            <div class="page-title">Product</div>
            <form class="search-form">
                <div class="input-group">
                    <button class="btn btn-outline-light" type="button" id="button-addon1">
                        <i class="bi bi-search"></i>
                    </button>
                    <input type="text" class="form-control" placeholder="Search..."
                        aria-label="Example text with button addon" aria-describedby="button-addon1">
                    <a href="#" class="btn btn-outline-light close-header-search-bar">
                        <i class="bi bi-x"></i>
                    </a>
                </div>
            </form>
            <!-- Header mobile buttons -->
            <div class="header-mobile-buttons">
                <a href="#" class="search-bar-btn">
                    <i class="bi bi-search"></i>
                </a>
                <a href="#" class="actions-btn">
                    <i class="bi bi-three-dots"></i>
                </a>
            </div>
            <!-- ./ Header mobile buttons -->
        </div>
        <!-- ./ header -->

        <!-- content -->
        <div class="content ">
            <div class="table-responsive">
                <a href="e-classes-add.html" class="btn btn-primary" aria-haspopup="true" aria-expanded="false">Add New
                    Product</a>
                <table class="table table-custom table-lg mb-0" id="orders">
                    <thead>
                        <tr>
                            <th>Class Name</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Amount</th>
                            <th>Image</th>
                            <th>Description</th>
                            <th>Action</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                        <tr>
                            <td>Lorem Ipsum</td>
                            <td>23-01-22</td>
                            <td>2:30pm</td>
                            <td>$20</td>
                            <td><img src="../../assets/images/user/women_avatar1.jpg" class="" alt="image"></td>
                            <td>Lorem Ipsum</td>
                            <td><a href="e-classes-view.html"><i class="bi bi-eye-fill"></i></a></td>
                            <td><i class="bi bi-pencil-square"></i></td>
                            <td><i class="bi bi-trash me-0"></i></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <nav class="mt-4" aria-label="Page navigation example">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>

        </div>
        <!-- ./ content -->

        <!-- content-footer -->
        <footer class="content-footer">
            <div>© 2022 Rez</div>
            <div>
                <nav class="nav gap-4">
                    <a href="privacy-policy.html" class="nav-link">Privacy Policy</a>
                    <a href="terms-conditions.html" class="nav-link">Terms & Conditions</a>
                </nav>
            </div>
        </footer>
        <!-- ./ content-footer -->

    </div>
@endsection
