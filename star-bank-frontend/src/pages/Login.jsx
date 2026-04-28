import React, { useState } from 'react';
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import './Login.css'; 

const Login = () => {
  const [email, setEmail] = useState('');
  const [pin, setPin] = useState('');
  const [showPassword, setShowPassword] = useState(false);
  const [error, setError] = useState('');
  const navigate = useNavigate(); 

  const handleLogin = async (e) => {
    e.preventDefault();
    setError(''); 

    try {
      const response = await axios.post('http://localhost:8000/api/auth/login', {
        email: email,
        pin: pin
      });
      const userData = response.data.data;
      const role = userData.role;

      localStorage.setItem('role', role);
      localStorage.setItem('user_id', userData.user_id);
      localStorage.setItem('user_name', userData.name);

      alert('Login Berhasil! Selamat Datang, ' + userData.name);
      if (role === 'admin') {
        navigate('/admin/dashboard');
      } else {
        navigate('/customer/dashboard');
      }

    } catch (err) {
      setError(err.response?.data?.message || 'Login Gagal');
    }
  };

  return (
    <div className="login-container">
        <div className="header-container">
            <div className="logo-star" style={{ marginBottom: '15px' }}>★</div>
            <h1 className="bank-name">STAR BANK</h1>
        </div>

        <div className="login-card">
        <form onSubmit={handleLogin}>
            <p className="form-subtitle">Sign In to Your Account</p>
            
            {error && <div className="error-msg" style={{ color: 'red', textAlign: 'center', marginBottom: '10px' }}>{error}</div>}

            <input 
              type="email" 
              placeholder="Email"
              className="input-field"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              required
            />

            <div className="password-wrapper" style={{ position: 'relative' }}>
              <input 
                type={showPassword ? "text" : "password"} 
                placeholder="PIN" 
                className="input-field"
                value={pin}
                onChange={(e) => setPin(e.target.value)}
                required
                style={{ width: '100%' }}
              />
              <span 
                className="toggle-password" 
                onClick={() => setShowPassword(!showPassword)}
                style={{
                  position: 'absolute',
                  right: '15px',
                  top: '50%',
                  transform: 'translateY(-50%)',
                  cursor: 'pointer',
                  fontSize: '18px',
                  color: '#666'
                }}
              >
                {showPassword ? "👁️" : "🙈"}
              </span>
            </div>

            <button type="submit" className="login-button">
              Login
            </button>
        </form>
        </div>
    </div>
    );
};

export default Login;