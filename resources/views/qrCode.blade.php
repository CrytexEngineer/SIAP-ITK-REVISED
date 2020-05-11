@extends('layouts.app')
@section('title','Kode QR')
@section('content')
    <div class="container" >
        <div class="row justify-content-center">
            <div class="col-md-12">
                <br class="card">
                <input type="hidden" value={{$PT_ID}} id="PT_ID">
                <div class="card-header">Kode QR</div>

                <table class="table-borderless">
                    <tr>
                        <td>
                            <div class="card-body" name="QR_Code_viewer" id="QR_Code_viewer"></div>
                        </td>
                        <td align="center">
                            <h1 align="center"><p name="presence_count" id="presence_count"></p></h1>
                            <h6 align="center">Mahasiswa<br>
                                Hadir
                            </h6>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    </div>

@endsection


<script>

    setInterval(function () {
    var PT_ID = $('#PT_ID').val();
        $.ajax({
            type: "GET",
            url: "/validator/generateQrCode/"+ PT_ID,
            success: function (response) {
                // If not false, update the post
                if (response) {
                    console.log(response)
                    $('#QR_Code_viewer').html(response);
                }
            }
        });
    }, 9000); // Do this every 5 seconds

   setInterval(function () {
    var PT_ID = $('#PT_ID').val();
        $.ajax({
            type: "GET",
            url: "/kehadiran/presenceCount/"+PT_ID,
            success: function (response) {
                // If not false, update the post
                if (response) {
                    console.log(response)
                    $('#presence_count').html(response);
                }
            }
        });
    }, 1000); // Do this every 5 seconds





</script>


