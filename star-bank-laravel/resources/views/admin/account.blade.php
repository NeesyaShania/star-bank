@extends('layout')

@section('content')
<div style="padding: 40px;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 5px;">Data Account</h1>
    <p style="color: #666; margin-bottom: 30px;">Kelola Data Account </p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="position: relative; width: 400px;">
            <span style="position: absolute; left: 15px; top: 12px; color: #aaa;">🔍</span>
            <input type="text" id="searchInput" placeholder="Search Account" 
                   style="width: 100%; padding: 12px 12px 12px 45px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
        </div>

        <a href="/admin/account/create" class="btn-tambah" style="text-decoration: none; background-color: #4da3ff; color: white; padding: 10px 20px; border-radius: 8px; font-weight: bold;">
            + Tambah Account
        </a>
    </div>

    <table class="custom-table" id="accountTable">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Account</th>
                <th>Nama Customer</th>
                <th>Jenis Deposito</th>
                <th>Saldo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($accounts as $index => $acc)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $acc->id }}</td>
                <td>{{ $acc->customer->name ?? 'N/A' }}</td>
                <td>{{ $acc->depositoType->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($acc->balance, 0, ',', '.') }}</td>
                <td>
                    <a href="/admin/account/edit/{{ $acc->id }}" style="text-decoration: none; margin-right: 10px;">📝</a>
                    
                    <form id="delete-form-{{ $acc->id }}" action="/admin/account/delete/{{ $acc->id }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="button" style="border:none; background:none; cursor:pointer;" onclick="confirmDelete('{{ $acc->id }}')">🗑️</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let rows = document.querySelectorAll('#accountTable tbody tr');
        rows.forEach(row => {
            let text = row.innerText.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Account?',
            text: "Apa anda yakin ingin menghapus rekening ini?",
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