@extends('layout')

@section('content')
<div style="padding: 40px;">
    <h1 style="font-size: 2rem; font-weight: bold; margin-bottom: 5px;">Data Customer</h1>
    <p style="color: #666; margin-bottom: 30px;">Kelola Data Customer</p>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div style="position: relative; width: 400px;">
            <span style="position: absolute; left: 15px; top: 12px; color: #aaa;">🔍</span>
            <input type="text" id="searchInput" placeholder="Search" 
                   style="width: 100%; padding: 12px 12px 12px 45px; border: 1px solid #ddd; border-radius: 10px; font-size: 1rem;">
        </div>

        <button type="button" class="btn-tambah" 
                onclick="console.log('Tombol diklik!'); window.location.href='{{ url('/admin/customer/create') }}';"
                style="position: relative; z-index: 999; cursor: pointer !important;">
            + Tambah Data
        </button>
    </div>

    <table class="custom-table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="customerTableBody">
            @foreach($customers as $index => $cust)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $cust->id }}</td>
                <td>{{ $cust->name }}</td>
                <td>{{ $cust->email }}</td>
                <td>
                    <a href="/admin/customer/edit/{{ $cust->id }}" class="edit-icon" style="text-decoration: none;">📝</a>
                    <form id="delete-form-{{ $cust->id }}" action="/admin/customer/delete/{{ $cust->id }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>

                    <button type="button" class="delete-icon" style="border:none; background:none; cursor:pointer;" 
                            onclick="confirmDelete('{{ $cust->id }}')">
                        🗑️
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    const searchInput = document.getElementById('searchInput');
    const tableBody = document.querySelector('.custom-table tbody');

    searchInput.addEventListener('keyup', function() {
        const filter = searchInput.value.toLowerCase();
        const rows = tableBody.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const nameColumn = rows[i].getElementsByTagName('td')[2];
            const emailColumn = rows[i].getElementsByTagName('td')[3];

            if (nameColumn || emailColumn) {
                const nameText = nameColumn.textContent || nameColumn.innerText;
                const emailText = emailColumn.textContent || emailColumn.innerText;

                if (nameText.toLowerCase().indexOf(filter) > -1 || 
                    emailText.toLowerCase().indexOf(filter) > -1) {
                    rows[i].style.display = "";
                } else {
                    rows[i].style.display = "none"; 
                }
            }
        }
    });
</script>
@endsection

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Hapus Data Customer ?',
        text: "Apa anda yakin ingin menghapus data ini ?",
        icon: 'warning', 
        showCancelButton: true,
        confirmButtonColor: '#e31a1a', 
        cancelButtonColor: '#bdbdbd', 
        confirmButtonText: 'Hapus',
        cancelButtonText: 'Batal',
        borderRadius: '20px', 
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-form-' + id).submit();
        }
    })
}
</script>