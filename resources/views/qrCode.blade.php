@extends('layouts.app')
@section('title','Kode QR')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Kode QR</div>

                    <div class="card-body" name="QR_Code_viewer" id="QR_Code_viewer">

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection


<script>

    setInterval(function () {
        $.ajax({
            type: "GET",
            url: "/validator/2",
            success: function (response) {
                // If not false, update the post
                if (response) {
                    console.log(response)
                    $('#QR_Code_viewer').html(response);
                }
            }
        });
    }, 1000); // Do this every 5 seconds


</script>


