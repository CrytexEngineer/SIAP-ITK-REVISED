<div class="form-group row">
    <label class="col-md-3 col-form-label text-md-right">Mahasiswa</label>

    <input type="hidden"  name="ke_id"  id="ke_id" class="form-control input"  value={{$kelas}}>

    <div class="col-md-5">
        <input type="text" name="KU_MA_Nrp" id="KU_MA_Nrp" class="form-control input"
               placeholder="Masukan Nama Mahasiswa"/>
        <div id="mahasiswalist">
        </div>

        <div class="mt-3">   {{ Form::submit('Simpan Data',['class'=>'btn btn-primary'])}}
            <a href="/khs" class="btn btn-primary">Kembali</a></div>
    </div>
</div>

    @push('scripts')
        <script>
    $(document).ready(function(){

        $('#KU_MA_Nrp').keyup(function(){
            var query = $(this).val();
            if(query != '')
            {
                var _token = $('input[name="_token"]').val();
                $.ajax({
                    url:"{{ route('frs.fetch_mahasiswa') }}",
                    method:"POST",
                    data:{query:query, _token:_token},
                    success:function(data){
                        $('#mahasiswalist').fadeIn();
                        $('#mahasiswalist').html(data);
                    }
                });
            }
        });

        $(document).on('click', 'li', function(){
            $('#KU_MA_Nrp').val($(this).text());
            $('#mahasiswalist').fadeOut();
        });

    });

        </script>
@endpush
