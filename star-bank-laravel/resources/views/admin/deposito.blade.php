@extends('layout')

@section('content')
<div style="padding: 40px;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 5px;">Data Tipe Deposito</h1>
    <p style="color: #666; margin-bottom: 30px;">Kelola Jenis dan Bunga Deposito</p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="position: relative; width: 400px;">
            <span style="position: absolute; left: 15px; top: 12px; color: #aaa;">🔍</span>
            <input type="text" id="searchInput" placeholder="Cari Tipe Deposito..." 
                   style="width: 100%; padding: 12px 12px 12px 45px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
        </div>

        <a href="/admin/deposit/create" style="text-decoration: none; background-color: #4da3ff; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold;">
            + Tambah Tipe
        </a>
    </div>

    <table class="custom-table" id="depositoTable">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Tipe</th>
                <th>Jenis Deposito</th>
                <th>Bunga Tahunan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($depositoTypes as $index => $type)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $type->id }}</td>
                <td>{{ $type->name }}</td>
                <td>{{ $type->yearly_return }} %</td>
                <td>
                    <a href="/admin/deposit/edit/{{ $type->id }}" style="text-decoration: none; margin-right: 10px;">📝</a>
                    
                    <form id="delete-form-{{ $type->id }}" action="/admin/deposit/delete/{{ $type->id }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" style="border:none; background:none; cursor:pointer;" onclick="confirmDelete('{{ $type->id }}')">🗑️</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    // Fitur Search
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#depositoTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    // Fitur Konfirmasi Hapus
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Tipe Deposito?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e31a1a',
            cancelButtonColor: '#bdbdbd',
            confirmButtonText: 'Hapus',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
</script>
@endsection