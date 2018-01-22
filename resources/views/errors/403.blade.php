@extends('layouts.index')

@section('content')
    <section class="content">
        <div class="error-page">
            <h2 class="headline text-yellow"> 403</h2>

            <div class="error-content">
                <h3><i class="fa fa-warning text-yellow"></i> Oops! You don't have enough rights to perform this action.</h3>

                <p>
                    Unfortunately we cannot give you a chance to perform something by your request.<br>
                    Meanwhile, you may <a href="/">return to main page</a>.
                </p>
            </div>
            <!-- /.error-content -->
        </div>
        <!-- /.error-page -->
    </section>
@endsection