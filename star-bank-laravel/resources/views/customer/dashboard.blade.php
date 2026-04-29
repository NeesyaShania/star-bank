@extends('layout_customer')

@section('content')
<div style="max-width: 1100px;">
    <p style="color: #666; font-size: 1.1rem; margin-bottom: 5px;">Selamat Datang, {{ Auth::user()->name }}</p>
    
    <div style="display: flex; gap: 20px; margin-bottom: 40px; flex-wrap: wrap;">
        @foreach($accounts as $acc)
        <div style="background: #cfe6ff; padding: 25px; border-radius: 20px; width: 320px; box-shadow: 0 8px 20px rgba(0,0,0,0.05); position: relative; border: 1px solid #b3d7ff;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <span style="font-weight: 800; font-size: 1.1rem; color: #333;">Deposit {{ $acc->depositoType->name }}</span>
                <span style="color: #666; font-size: 0.85rem; font-weight: 600;">{{ $acc->id }}</span>
            </div>
            
            <div style="margin-top: 25px;">
                <span style="font-size: 0.85rem; color: #777;">Saldo efektif</span>
                <h2 style="margin: 5px 0; font-size: 1.8rem; font-weight: 800; color: #222;">
                    Rp. {{ number_format($acc->balance, 0, ',', '.') }}
                </h2>
            </div>
            
            <div style="margin-top: 15px; text-align: right;">
                <span style="font-size: 0.8rem; color: #666; background: rgba(255,255,255,0.5); padding: 4px 10px; border-radius: 10px;">
                    Bunga: {{ $acc->depositoType->yearly_return }}% per tahun
                </span>
            </div>
        </div>
        @endforeach
    </div>

    <div style="display: flex; justify-content: center; gap: 20px; margin-bottom: 40px;">
        <a href="/customer/deposit" style="background: #4682b4; color: white; padding: 15px 45px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(70, 130, 180, 0.3); display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 1.3rem;">+</span> Deposit
        </a>
        
        <a href="/customer/withdraw" style="background: #e31a1a; color: white; padding: 15px 45px; border-radius: 12px; text-decoration: none; font-weight: bold; font-size: 1.1rem; box-shadow: 0 4px 12px rgba(227, 26, 26, 0.3); display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 1.3rem;">−</span> Withdraw
        </a>
    </div>

    <h3 style="font-weight: 800; margin-bottom: 20px;">Riwayat Transaksi</h3>
    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.03);">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: #f8fbff; border-bottom: 2px solid #f0f0f0;">
                <tr>
                    <th style="padding: 15px;">No</th>
                    <th style="padding: 15px;">Tanggal</th>
                    <th style="padding: 15px;">ID Rekening</th>
                    <th style="padding: 15px;">Jenis Transaksi</th>
                    <th style="padding: 15px; text-align: right;">Nominal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $index => $t)
                <tr style="border-bottom: 1px solid #f9f9f9;">
                    <td style="padding: 15px;">{{ $index + 1 }}</td>
                    <td style="padding: 15px;">{{ date('d-m-Y', strtotime($t->created_at)) }}</td>
                    <td style="padding: 15px;">{{ $t->account_id }}</td>
                    <td style="padding: 15px; text-transform: capitalize;">{{ $t->transaction_type }}</td>
                    <td style="padding: 15px; text-align: right; font-weight: bold; color: {{ $t->transaction_type == 'deposit' ? '#28a745' : '#e31a1a' }}">
                        {{ $t->transaction_type == 'deposit' ? '+' : '-' }} Rp. {{ number_format($t->amount, 0, ',', '.') }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection