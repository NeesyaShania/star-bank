import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './CustomerDashboard.css';

const CustomerDashboard = () => {
    const navigate = useNavigate();
    const [accounts, setAccounts] = useState([]);
    const [transactions, setTransactions] = useState([]);
    const userName = localStorage.getItem('user_name') || 'Customer';

    const [showDepositModal, setShowDepositModal] = useState(false);
    const [depositData, setDepositData] = useState({
        account_id: '',
        transaction_date: new Date().toISOString().split('T')[0],
        amount: ''
    });

    const [showWithdrawModal, setShowWithdrawModal] = useState(false);
    const [withdrawData, setWithdrawData] = useState({
        account_id: '',
        transaction_date: new Date().toISOString().split('T')[0],
        amount: ''
    });
    const [summary, setSummary] = useState({
        initialBalance: 0,
        interestEarned: 0,
        finalBalance: 0
    });

    useEffect(() => {
        const role = localStorage.getItem('role');
        if (role !== 'customer') {
            navigate('/');
            return;
        }
        fetchData();
    }, [navigate]);

    useEffect(() => {
        const selectedAcc = accounts.find(a => a.id === withdrawData.account_id);
        if (selectedAcc) {
            const initial = Math.floor(parseFloat(selectedAcc.balance));
            const amount = Math.floor(parseFloat(withdrawData.amount)) || 0;
            const interest = Math.floor(initial * ((selectedAcc.deposito_type?.yearly_return || 0) / 100 / 12)); 
            
            setSummary({
                initialBalance: initial,
                interestEarned: interest,
                finalBalance: initial + interest - amount 
            });
        }
    }, [withdrawData, accounts]);

    const handleDepositSubmit = async (e) => {
        e.preventDefault();
        try {
            const res = await axios.post('http://localhost:8000/api/customer/deposit', depositData);
            alert('Setoran berhasil!');
            setShowDepositModal(false); 
            fetchData(); 
        } catch (err) {
            console.error(err);
            alert('Gagal melakukan setoran.');
        }
    };

    const handleWithdrawSubmit = async (e) => {
        e.preventDefault();
        try {
            const res = await axios.post('http://localhost:8000/api/customer/withdraw', withdrawData);
            alert('Penarikan berhasil!');
            setShowWithdrawModal(false);
            fetchData();
        } catch (err) {
            const errorMsg = err.response?.data?.message || 'Gagal melakukan penarikan.';
            alert(errorMsg);
        }
    };

    const fetchData = async () => {
        try {
            const userId = localStorage.getItem('user_id');
            const res = await axios.get(`http://localhost:8000/api/customer/dashboard/${userId}`);
            console.log("Response API:", res.data);
            const dataFromApi = res.data.data || res.data;
            
            setAccounts(dataFromApi.accounts || []);
            setTransactions(dataFromApi.transactions || []);
        } catch (err) {
            console.error("Gagal memuat data:", err);
        }
    };

    const handleLogout = () => {
        localStorage.clear();
        navigate('/');
    };

    return (
        <div className="cust-wrapper">
            {/* Sidebar */}
            <aside className="cust-sidebar">
                <div className="cust-sidebar-header">
                    <div className="cust-logo-star">★</div>
                    <h1 className="cust-sidebar-title">STAR BANK</h1>
                </div>
                
                <p className="cust-menu-label">Utama</p>
                
                <nav className="cust-nav">
                    <div className="cust-nav-group active">
                        <span className="icon">👤</span>
                        <button className="nav-link">Dashboard</button>
                    </div>
                    <div className="cust-nav-group logout-item" onClick={handleLogout}>
                        <span className="icon">➡️</span>
                        <button className="nav-link">Log Out</button>
                    </div>
                </nav>
            </aside>

            {/* Main Content */}
            <main className="cust-main">
                <p className="welcome-text">Selamat Datang, <strong>{userName}</strong></p>

                {/* Kartu Rekening */}
                <section className="cust-cards-wrapper">
                    {accounts.length > 0 ? accounts.map((acc) => (
                        <div className="cust-balance-card" key={acc.id}>
                            <div className="card-header">
                                <span className="deposit-label">Deposit {acc.deposito_type?.name}</span>
                                <span className="acc-id">{acc.id}</span> 
                            </div>
                            <div className="card-body">
                                <p className="saldo-label">Saldo efektif</p>
                                <h2 className="saldo-value">Rp. {parseFloat(acc.balance).toLocaleString('id-ID')}</h2>
                            </div>
                            <div className="card-footer">
                                Bunga: {acc.deposito_type?.yearly_return}% per tahun
                            </div>
                        </div>
                    )) : (
                        <p className="loading-text">Tidak ada akun rekening aktif.</p>
                    )}
                </section>

                {/* Tombol Aksi */}
                <section className="cust-btn-group">
                    <button className="btn-deposit" onClick={() => setShowDepositModal(true)}>+ Deposit</button>
                    <button className="btn-withdraw" onClick={() => setShowWithdrawModal(true)}>- Withdraw</button>
                </section>

                {/* Tabel Transaksi */}
                <section className="cust-history">
                    <h3 className="section-title">Riwayat Transaksi</h3>
                    <div className="cust-table-wrapper">
                        <table className="cust-table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>ID Rekening</th>
                                    <th>Jenis Transaksi</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                {transactions.length > 0 ? transactions.map((tx, index) => (
                                    <tr key={tx.id}>
                                        <td>{index + 1}</td>
                                        <td>{tx.transaction_date || tx.created_at?.split('T')[0]}</td>
                                        <td>{tx.account_id}</td>
                                        <td>{tx.transaction_type}</td>
                                        <td className={tx.transaction_type.toLowerCase() === 'deposit' ? 'text-green' : 'text-red'}>
                                            {tx.transaction_type.toLowerCase() === 'deposit' ? '+ ' : '- '}
                                            Rp. {parseFloat(tx.amount).toLocaleString('id-ID')}
                                        </td>
                                    </tr>
                                )) : (
                                    <tr>
                                        <td colSpan="5" className="text-center">Belum ada riwayat transaksi.</td>
                                    </tr>
                                )}
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>

            {/* Modal Pop-up Deposit */}
            {showDepositModal && (
                <div className="modal-overlay">
                    <div className="modal-content">
                        <button className="close-btn" onClick={() => setShowDepositModal(false)}>&times;</button>
                        <h2 className="modal-title">Setor Dana (Deposit)</h2>
                        
                        <form onSubmit={handleDepositSubmit}>
                            <div className="form-group">
                                <label>Rekening Tujuan</label>
                                <select 
                                    required
                                    value={depositData.account_id}
                                    onChange={(e) => setDepositData({...depositData, account_id: e.target.value})}
                                >
                                    <option value="">Pilih Rekening</option>
                                    {accounts.map(acc => (
                                        <option key={acc.id} value={acc.id}>{acc.id} - {acc.deposito_type?.name}</option>
                                    ))}
                                </select>
                            </div>

                            <div className="form-group">
                                <label>Tanggal Transaksi</label>
                                <input 
                                    type="date" 
                                    required
                                    value={depositData.transaction_date}
                                    onChange={(e) => setDepositData({...depositData, transaction_date: e.target.value})}
                                />
                            </div>

                            <div className="form-group">
                                <label>Nominal</label>
                                <div className="input-prefix-wrapper">
                                    <span className="prefix">Rp.</span>
                                    <input 
                                        type="number" 
                                        placeholder="0"
                                        required
                                        value={depositData.amount}
                                        onChange={(e) => setDepositData({...depositData, amount: e.target.value})}
                                    />
                                </div>
                            </div>

                            <div className="modal-actions">
                                <button type="button" className="btn-batal" onClick={() => setShowDepositModal(false)}>Batal</button>
                                <button type="submit" className="btn-setor">Setor Dana</button>
                            </div>
                        </form>
                    </div>
                </div>
            )}

            {/* Modal Pop Up Withdraw */}
            {showWithdrawModal && (
                <div className="modal-overlay">
                    <div className="modal-content">
                        <button className="close-btn" onClick={() => setShowWithdrawModal(false)}>&times;</button>
                        <h2 className="modal-title">Tarik Dana (Withdraw)</h2>
                        
                        <form onSubmit={handleWithdrawSubmit}>
                            <div className="form-group">
                                <label>Sumber Rekening</label>
                                <select 
                                    required
                                    value={withdrawData.account_id}
                                    onChange={(e) => setWithdrawData({...withdrawData, account_id: e.target.value})}
                                >
                                    <option value="">Pilih Rekening</option>
                                    {accounts.map(acc => (
                                        <option key={acc.id} value={acc.id}>{acc.id} - {acc.deposito_type?.name}</option>
                                    ))}
                                </select>
                            </div>

                            <div className="form-group">
                                <label>Tanggal Transaksi</label>
                                <input 
                                    type="date" 
                                    value={withdrawData.transaction_date}
                                    onChange={(e) => setWithdrawData({...withdrawData, transaction_date: e.target.value})}
                                />
                            </div>

                            <div className="form-group">
                                <label>Nominal</label>
                                <div className="input-prefix-wrapper">
                                    <span className="prefix">Rp.</span>
                                    <input 
                                        type="number" 
                                        placeholder="0"
                                        value={withdrawData.amount}
                                        onChange={(e) => setWithdrawData({...withdrawData, amount: e.target.value})}
                                    />
                                </div>
                                <small className="info-minimal">* Minimal penarikan Rp. 10.000</small>
                            </div>

                            <div className="withdraw-summary">
                                <p>Saldo Awal: Rp. {summary.initialBalance.toLocaleString('id-ID')}</p>
                                <p>Bunga Didapat: Rp. {summary.interestEarned.toLocaleString('id-ID')}</p>
                                <p className="total-final">Total Saldo Akhir: Rp. {summary.finalBalance.toLocaleString('id-ID')}</p>
                            </div>

                            <div className="modal-actions">
                                <button type="button" className="btn-batal" onClick={() => setShowWithdrawModal(false)}>Batal</button>
                                <button type="submit" className="btn-tarik"disabled={parseFloat(withdrawData.amount) < 10000 || parseFloat(withdrawData.amount) > summary.initialBalance}>Tarik Dana</button>
                            </div>
                        </form>
                    </div>
                </div>
            )}
        </div>
    );
};

export default CustomerDashboard;