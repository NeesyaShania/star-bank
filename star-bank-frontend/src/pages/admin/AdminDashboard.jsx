import React, { useState, useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';
import './AdminDashboard.css';

const AdminDashboard = () => {
    const navigate = useNavigate();
    const [activeMenu, setActiveMenu] = useState('customer');
    const [customers, setCustomers] = useState([]);
    const [accounts, setAccounts] = useState([]);
    const [depositTypes, setDepositTypes] = useState([]);
    const [searchTerm, setSearchTerm] = useState('');

    const [showModal, setShowModal] = useState(false);
    const [showPassword, setShowPassword] = useState(false); 
    const [isEdit, setIsEdit] = useState(false);
    const [selectedId, setSelectedId] = useState(null);
    const [showDeleteModal, setShowDeleteModal] = useState(false);
    const [deleteId, setDeleteId] = useState(null);
    const [formData, setFormData] = useState({ name: '', email: '', pin: '' });

    const [showAccModal, setShowAccModal] = useState(false);
    const [isEditAcc, setIsEditAcc] = useState(false);
    const [selectedAccId, setSelectedAccId] = useState(null);
    const [showDeleteAccModal, setShowDeleteAccModal] = useState(false);
    const [deleteAccId, setDeleteAccId] = useState(null);
    const [accFormData, setAccFormData] = useState({
        customer_id: '',
        deposito_type_id: '',
        balance: ''
    });

    const [showDepoModal, setShowDepoModal] = useState(false);
    const [isEditDepo, setIsEditDepo] = useState(false);
    const [selectedDepoId, setSelectedDepoId] = useState(null);
    const [showDeleteDepoModal, setShowDeleteDepoModal] = useState(false);
    const [deleteDepoId, setDeleteDepoId] = useState(null);
    const [depoFormData, setDepoFormData] = useState({ name: '', yearly_return: '' });

    useEffect(() => {
        setSearchTerm('');
        if (activeMenu === 'customer') fetchCustomers();
        if (activeMenu === 'account') {
            fetchAccounts();
            fetchCustomers();
            fetchDepositTypes();
        }
        if (activeMenu === 'deposit') fetchDepositTypes();
    }, [activeMenu]);

    const handleLogout = () => {
        localStorage.clear();
        alert("Berhasil Log Out. Sampai jumpa lagi, Admin! 👋");
        navigate('/'); 
    };

    const fetchCustomers = async () => {
        try {
            const res = await axios.get('http://localhost:8000/api/admin/customers');
            setCustomers(res.data.data || res.data);
        } catch (err) { console.error(err); }
    };

    const fetchAccounts = async () => {
        try {
            const res = await axios.get('http://localhost:8000/api/admin/accounts');
            setAccounts(res.data.data || res.data);
        } catch (err) { console.error(err); }
    };

    const fetchDepositTypes = async () => {
        try {
            const res = await axios.get('http://localhost:8000/api/admin/deposito-types');
            setDepositTypes(res.data.data || res.data);
        } catch (err) { console.error(err); }
    };

    const handleInputChange = (e) => {
        const { name, value } = e.target;
        if (name === 'pin' && value.length > 6) return;
        setFormData({ ...formData, [name]: value });
    };

    const filteredCustomers = customers.filter(c => 
        c.name.toLowerCase().includes(searchTerm.toLowerCase()) || 
        c.email.toLowerCase().includes(searchTerm.toLowerCase()) ||
        c.id.toString().includes(searchTerm)
    );

    const filteredAccounts = accounts.filter(a => 
        (a.customer?.name || '').toLowerCase().includes(searchTerm.toLowerCase()) ||
        a.id.toString().includes(searchTerm) ||
        (a.account_number || '').includes(searchTerm)
    );

    const filteredDepositTypes = depositTypes.filter(d => 
        d.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
        d.id.toString().includes(searchTerm)
    );

    const handleAddClick = () => {
        setIsEdit(false);
        setShowPassword(false); 
        setFormData({ name: '', email: '', pin: '' });
        setShowModal(true);
    };

    const handleEditClick = (cust) => {
        setIsEdit(true);
        setShowPassword(false); 
        setSelectedId(cust.id);
        setFormData({ name: cust.name, email: cust.email, pin: '' });
        setShowModal(true);
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        const payload = { ...formData };
        if (isEdit && (!payload.pin || payload.pin.trim() === "")) delete payload.pin;
        try {
            if (isEdit) await axios.put(`http://localhost:8000/api/admin/customers/${selectedId}`, payload);
            else await axios.post('http://localhost:8000/api/admin/customers', payload);
            setShowModal(false);
            fetchCustomers();
            alert("Data Berhasil Disimpan!");
        } catch (err) { alert("Gagal menyimpan data!"); }
    };

    const handleDelete = async () => {
        try {
            await axios.delete(`http://localhost:8000/api/admin/customers/${deleteId}`);
            setShowDeleteModal(false);
            fetchCustomers();
            alert("Data Dihapus!");
        } catch (err) { alert("Gagal menghapus data!"); }
    };

    const handleAccSubmit = async (e) => {
        e.preventDefault();
        try {
            if (isEditAcc) await axios.put(`http://localhost:8000/api/admin/accounts/${selectedAccId}`, accFormData);
            else await axios.post('http://localhost:8000/api/admin/accounts', accFormData);
            setShowAccModal(false);
            fetchAccounts();
            alert("Akun Berhasil Disimpan!");
        } catch (err) { alert("Gagal menyimpan akun!"); }
    };

    const handleEditAccClick = (acc) => {
        setIsEditAcc(true);
        setSelectedAccId(acc.id);
        setAccFormData({ customer_id: acc.customer_id, deposito_type_id: acc.deposito_type_id, balance: acc.balance });
        setShowAccModal(true);
    };

    const handleDeleteAcc = async () => {
        try {
            await axios.delete(`http://localhost:8000/api/admin/accounts/${deleteAccId}`);
            setShowDeleteAccModal(false);
            fetchAccounts();
            alert("Rekening Dihapus!");
        } catch (err) { alert("Gagal menghapus rekening!"); }
    };

    const handleDepoSubmit = async (e) => {
        e.preventDefault();
        try {
            if (isEditDepo) await axios.put(`http://localhost:8000/api/admin/deposito-types/${selectedDepoId}`, depoFormData);
            else await axios.post('http://localhost:8000/api/admin/deposito-types', depoFormData);
            setShowDepoModal(false);
            fetchDepositTypes();
            alert("Tipe Berhasil Disimpan!");
        } catch (err) { alert("Gagal menyimpan tipe!"); }
    };

    const handleEditDepoClick = (depo) => {
        setIsEditDepo(true);
        setSelectedDepoId(depo.id);
        setDepoFormData({ name: depo.name, yearly_return: depo.yearly_return });
        setShowDepoModal(true);
    };

    const handleDeleteDepo = async () => {
        try {
            await axios.delete(`http://localhost:8000/api/admin/deposito-types/${deleteDepoId}`);
            setShowDeleteDepoModal(false);
            fetchDepositTypes();
            alert("Tipe Dihapus!");
        } catch (err) { alert("Gagal menghapus tipe!"); }
    };

    return (
        <div className="admin-wrapper">
            <aside className="admin-sidebar">
                <div className="sidebar-header">
                    <div className="logo-star-small">★</div>
                    <h1 className="sidebar-title">STAR BANK</h1>
                </div>
                <p className="menu-label">UTAMA</p>
                <nav className="admin-nav">
                    <div className={`nav-group ${activeMenu === 'customer' ? 'active' : ''}`} onClick={() => setActiveMenu('customer')}>
                        <span className="icon">👤</span><button className="nav-link">Data Customer</button>
                    </div>
                    <div className={`nav-group ${activeMenu === 'account' ? 'active' : ''}`} onClick={() => setActiveMenu('account')}>
                        <span className="icon">💳</span><button className="nav-link">Data Account</button>
                    </div>
                    <div className={`nav-group ${activeMenu === 'deposit' ? 'active' : ''}`} onClick={() => setActiveMenu('deposit')}>
                        <span className="icon">📊</span><button className="nav-link">Tipe Deposit</button>
                    </div>
                    <div className="nav-group logout-group" onClick={handleLogout} style={{ cursor: 'pointer' }}>
                        <span className="icon">➡️</span><button className="nav-link">Log Out</button>
                    </div>
                </nav>
            </aside>

            <main className="admin-main">
                <header className="main-header">
                    <h2 className="title-text">
                        {activeMenu === 'customer' ? 'Data Customer' : activeMenu === 'account' ? 'Data Account' : 'Tipe Deposito'}
                    </h2>
                    <p className="subtitle-text">
                        Kelola {activeMenu === 'customer' ? 'Data Nasabah' : activeMenu === 'account' ? 'Data Rekening' : 'Kategori Tabungan'}
                    </p>
                </header>

                <section className="action-bar">
                    <div className="search-container">
                        <div className="search-box">
                            <span className="search-icon">🔍</span>
                            <input 
                                type="text" 
                                placeholder={`Cari ${activeMenu}...`} 
                                value={searchTerm}
                                onChange={(e) => setSearchTerm(e.target.value)}
                            />
                        </div>
                        <button className="btn-search-modern">Cari</button>
                    </div>
                    
                    <button className="btn-tambah" onClick={() => {
                        if(activeMenu === 'customer') handleAddClick();
                        else if(activeMenu === 'account') {
                            setIsEditAcc(false);
                            setAccFormData({ customer_id: '', deposito_type_id: '', balance: '' });
                            setShowAccModal(true);
                        } else {
                            setIsEditDepo(false);
                            setDepoFormData({ name: '', yearly_return: '' });
                            setShowDepoModal(true);
                        }
                    }}>
                        + Tambah Data
                    </button>
                </section>

                <div className="table-wrapper">
                    <table className="custom-table">
                        {activeMenu === 'customer' && (
                            <>
                                <thead><tr><th>NO</th><th>ID</th><th>NAMA</th><th>EMAIL</th><th>AKSI</th></tr></thead>
                                <tbody>
                                    {filteredCustomers.map((cust, index) => (
                                        <tr key={cust.id}><td>{index + 1}</td><td>{cust.id}</td><td>{cust.name}</td><td>{cust.email}</td>
                                            <td className="action-cells">
                                                <button className="edit-icon" onClick={() => handleEditClick(cust)}>📝</button>
                                                <button className="delete-icon" onClick={() => { setDeleteId(cust.id); setShowDeleteModal(true); }}>🗑️</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </>
                        )}

                        {activeMenu === 'account' && (
                            <>
                                <thead><tr><th>NO</th><th>ID AKUN</th><th>CUSTOMER</th><th>TIPE</th><th>BALANCE</th><th>AKSI</th></tr></thead>
                                <tbody>
                                    {filteredAccounts.map((acc, index) => (
                                        <tr key={acc.id}><td>{index + 1}</td><td>{acc.id}</td><td>{acc.customer?.name}</td><td>{acc.deposito_type?.name}</td><td>Rp {parseFloat(acc.balance).toLocaleString('id-ID')}</td>
                                            <td className="action-cells">
                                                <button className="edit-icon" onClick={() => handleEditAccClick(acc)}>📝</button>
                                                <button className="delete-icon" onClick={() => { setDeleteAccId(acc.id); setShowDeleteAccModal(true); }}>🗑️</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </>
                        )}

                        {activeMenu === 'deposit' && (
                            <>
                                <thead><tr><th>NO</th><th>ID TIPE</th><th>NAMA TIPE</th><th>BUNGA</th><th>AKSI</th></tr></thead>
                                <tbody>
                                    {filteredDepositTypes.map((depo, index) => (
                                        <tr key={depo.id}><td>{index + 1}</td><td>{depo.id}</td><td>{depo.name}</td><td>{depo.yearly_return}%</td>
                                            <td className="action-cells">
                                                <button className="edit-icon" onClick={() => handleEditDepoClick(depo)}>📝</button>
                                                <button className="delete-icon" onClick={() => { setDeleteDepoId(depo.id); setShowDeleteDepoModal(true); }}>🗑️</button>
                                            </td>
                                        </tr>
                                    ))}
                                </tbody>
                            </>
                        )}
                    </table>
                </div>

                {showModal && (
                    <div className="modal-overlay">
                        <div className="modal-content">
                            <div className="modal-header">
                                <h3>{isEdit ? 'Ubah Customer' : 'Tambah Customer'}</h3>
                                <button className="close-x" onClick={() => setShowModal(false)}>×</button>
                            </div>
                            <form onSubmit={handleSubmit}>
                                <div className="form-group-modal"><label>Nama</label><input type="text" value={formData.name} onChange={handleInputChange} name="name" required /></div>
                                <div className="form-group-modal"><label>Email</label><input type="email" value={formData.email} onChange={handleInputChange} name="email" required /></div>
                                <div className="form-group-modal">
                                    <label>PIN</label>
                                    <div className="password-input-wrapper">
                                        <input type={showPassword ? "text" : "password"} value={formData.pin} onChange={handleInputChange} name="pin" required={!isEdit} placeholder="6 Digit PIN" />
                                        <span className="password-toggle-icon" onClick={() => setShowPassword(!showPassword)}>{showPassword ? "👁️" : "🙈"}</span>
                                    </div>
                                    {formData.pin && formData.pin.length !== 6 && <small style={{color:'red'}}>* PIN wajib 6 karakter</small>}
                                </div>
                                <div className="modal-footer-center">
                                    <button type="button" className="btn-batal-modal" onClick={() => setShowModal(false)}>Batal</button>
                                    <button type="submit" className="btn-simpan-modal" disabled={(!isEdit && formData.pin.length !== 6) || (isEdit && formData.pin !== "" && formData.pin.length !== 6)}>Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                )}

                {showAccModal && (
                    <div className="modal-overlay">
                        <div className="modal-content">
                            <div className="modal-header"><h3>{isEditAcc ? 'Ubah Akun' : 'Buat Akun'}</h3><button className="close-x" onClick={() => setShowAccModal(false)}>×</button></div>
                            <form onSubmit={handleAccSubmit}>
                                <div className="form-group-modal"><label>Pilih Customer</label>
                                    <select value={accFormData.customer_id} onChange={(e) => setAccFormData({...accFormData, customer_id: e.target.value})} required>
                                        <option value="">-- Pilih Customer --</option>
                                        {customers.map(cust => (<option key={cust.id} value={cust.id}>{cust.name}</option>))}
                                    </select>
                                </div>
                                <div className="form-group-modal"><label>Tipe Deposito</label>
                                    <select value={accFormData.deposito_type_id} onChange={(e) => setAccFormData({...accFormData, deposito_type_id: e.target.value})} required>
                                        <option value="">-- Pilih Tipe --</option>
                                        {depositTypes.map(t => (<option key={t.id} value={t.id}>{t.name}</option>))}
                                    </select>
                                </div>
                                <div className="form-group-modal"><label>Balance (Rp)</label><input type="number" value={accFormData.balance} onChange={(e) => setAccFormData({...accFormData, balance: e.target.value})} required /></div>
                                <div className="modal-footer-center"><button type="button" className="btn-batal-modal" onClick={() => setShowAccModal(false)}>Batal</button><button type="submit" className="btn-simpan-modal">Simpan</button></div>
                            </form>
                        </div>
                    </div>
                )}

                {showDepoModal && (
                    <div className="modal-overlay">
                        <div className="modal-content">
                            <div className="modal-header"><h3>{isEditDepo ? 'Ubah Tipe' : 'Tambah Tipe'}</h3><button className="close-x" onClick={() => setShowDepoModal(false)}>×</button></div>
                            <form onSubmit={handleDepoSubmit}>
                                <div className="form-group-modal"><label>Nama Tipe</label><input type="text" value={depoFormData.name} onChange={(e) => setDepoFormData({...depoFormData, name: e.target.value})} required /></div>
                                <div className="form-group-modal"><label>Bunga Tahunan (%)</label><input type="number" value={depoFormData.yearly_return} onChange={(e) => setDepoFormData({...depoFormData, yearly_return: e.target.value})} required /></div>
                                <div className="modal-footer-center"><button type="button" className="btn-batal-modal" onClick={() => setShowDepoModal(false)}>Batal</button><button type="submit" className="btn-simpan-modal">Simpan</button></div>
                            </form>
                        </div>
                    </div>
                )}

                {(showDeleteModal || showDeleteAccModal || showDeleteDepoModal) && (
                    <div className="modal-overlay">
                        <div className="delete-modal-content">
                            <button className="close-x" onClick={() => { setShowDeleteModal(false); setShowDeleteAccModal(false); setShowDeleteDepoModal(false); }}>×</button>
                            <div className="delete-icon-warning">!</div>
                            <h2>Hapus Data?</h2>
                            <h4>Apakah anda yakin ingin menghapus data ini?</h4>
                            <div className="modal-footer-center">
                                <button className="btn-batal-modal" onClick={() => { setShowDeleteModal(false); setShowDeleteAccModal(false); setShowDeleteDepoModal(false); }}>Batal</button>
                                <button className="btn-hapus-action" onClick={() => {
                                    if(showDeleteModal) handleDelete();
                                    else if(showDeleteAccModal) handleDeleteAcc();
                                    else handleDeleteDepo();
                                }}>Hapus</button>
                            </div>
                        </div>
                    </div>
                )}
            </main>
        </div>
    );
};

export default AdminDashboard;