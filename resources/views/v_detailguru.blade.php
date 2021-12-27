@extends('layout.v_template')
@section('title', 'detail Guru')
@section('content')
    
<table class="table">
    <tr>
        <th width="100px">NIP</th>
        <th width="30px">:</th>
        <th>{{ $guru->nip }}</th>
    </tr>
    <tr>
        <th width="100px">Nama Guru</th>
        <th width="30px">:</th>
        <th>{{ $guru->nama_guru }}</th>
    </tr>
    <tr>
        <th width="100px">Mata Pelajaran</th>
        <th width="30px">:</th>
        <th>{{ $guru->mapel }}</th>
    </tr>    
    <tr>
        <th width="100px">Foto</th>
        <th width="30px">:</th>
        <th><img src="{{ url ('foto_guru/'.$guru->foto_guru) }}" width="100px"></th>
    </tr>
    <th>
        <a href="/guru" class="btn btn-success btn-sm">Kembali</a>
    </th>  
</table>

@endsection