@extends('layouts.app')
@section('title','Buat Presensi Mahasiswa')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Tambah Presensi Mahasiswa</div>
                    <div class="card-body">

                        @include('alert')
                        @include('validation_error')

                        @csrf
                        {{ Form::open(array('url' => '/presensi/')) }}

                        <table class="display compact"  align="center" >
                            <tr><td width="270">Nama Mahasiswa</td><td> {{ $mahasiswa->pluck('MA_NamaLengkap')[0]}}</td></tr>
                            <tr><td>Nomor Induk Mahaiswa</td><td>{{ $mahasiswa->pluck('MA_Nrp_Baru')[0]}}</td></tr>
                            <tr><td>Matakuliah</td><td>{{$mahasiswa->pluck('MK_ID')[0]}} - {{ $mahasiswa->pluck('MK_Mata_Kuliah')[0]}}</td></tr>
                            <tr><td>Kelas</td><td>{{ $mahasiswa->pluck('KU_KE_Kelas')[0]}}</td></tr>
                            <tr><td>Pertemuan</td><td> {{Form::select('PT_ID',$meeting,null,['class'=>'form-control','placeholder'=>'Pilih Pertemuan'])}}</td></tr>
                            <tr><td>Keterangan</td><td> {{Form::select('PT_Keterangan',['HADIR'=>'Hadir','SAKIT'=>'Sakit','IZIN'=>'Izin'],null,['class'=>'form-control','placeholder'=>'Pilih Keterangan'])}}
                            <tr><td></td><td><div class="float-md-right mt-2">{{Form::submit('Buat', ['class'=>'btn btn-primary'])}}</div></td></tr>
                        </table>


                        </div>


                        <input type="hidden" name="PT_KU_ID" id="PT_KU_ID"  class="form-control input" value={{$mahasiswa->pluck('KU_ID')[0]}}>
                        <input type="hidden" name="PT_KE_ID" id="PT_KE_ID"  class="form-control input" value={{$kelas}}>

                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(function() {

        var link='/presensi/'+$('#KU_ID').val()+'/manage/json';
        console.log(link);
                  $('#users-table').DataTable({
                dom: 'Blfrtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "scrollX": true,
                processing: true,
                serverSide: true,
                ajax: '/presensi/'+$('#KU_ID').val()+'/manage/json',
                columns: [
                    { data: 'PT_Urutan', name: 'PT_Urutan' },
                    { data: 'PT_Name', name: 'PT_Name' },
                         { data: 'PR_Keterangan', name: 'PR_Keterangan' },
                         { data: 'PR_Type', name: 'PR_Type' },
{{--                        @can('change')--}}
        {{--            { data: 'action', name: 'action' }--}}
        {{--@endcan--}}
        ]
    });
});
</script>
@endpush
