@extends('layouts.app')
@section('title', 'Export Berdasarkan Matakuliah')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">@yield('title')</div>

                    <div class="card-body">
                        @include('validation_error')


                        @csrf
                        {{ Form::open(array('url' => '/rekapitulasi/mahasiswa/export/subject')) }}


                        <div class="form-group row">

                            <div class="col-md-4">
                                {{Form::select('PS_ID',$major,null,['class'=>'form-control','placeholder'=>'Pilih Program Studi','id' => 'PS_ID'])}}
                            </div>


                            <div class="col-md-4">
                                {{Form::select('KE_KR_MK_ID',[],null,['class'=>'form-control','placeholder'=>'Pilih Matakuliah','id' => 'MK_ID'])}}
                            </div>


                            <div class="col-md-4">
                                {{Form::submit('Unduh', ['class'=>'btn btn-primary'])}}
                            </div>
                        </div>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(document).ready(function () {
                $('#PS_ID').on('change',function(e) {
                 var PS_ID = e.target.value;
                               $.ajax({
                       url:"{{ route('subjectQuery') }}",
                       type:"GET",
                       data: {
                           PS_ID: PS_ID
                        },
                       success:function (data) {
                          $('#MK_ID').empty();
                          $.each(data.subject,function(index,subcategory){
                          $('#MK_ID').append('<option value="'+subcategory.KE_KR_MK_ID+'">'+subcategory.MK_Mata_Kuliah +'</option>');
                        })
                       }
                   })
                });

            });





    </script>

@endsection
