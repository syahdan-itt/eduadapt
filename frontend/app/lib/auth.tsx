import axios from 'axios';
import { createContext, useContext, useEffect, useState, type ReactNode } from 'react';import { showSuccess, showError } from './swal';

axios.defaults.baseURL = 'http://localhost:8000';

interface User {
  id: number;
  name: string;
  email: string;
  role: number;
}

interface AuthContextType {
  user: User | null;
  token: string | null;
  login: (email: string, password: string) => Promise<void>;
  register: (name: string, email: string, password: string, role: number) => Promise<void>;
  logout: () => void;
  isLoading: boolean;
}

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error('useAuth must be used within an AuthProvider');
  }
  return context;
};

interface AuthProviderProps {
  children: ReactNode;
}

export const AuthProvider = ({ children }: AuthProviderProps) => {
  const [user, setUser] = useState<User | null>(null);
  const [token, setToken] = useState<string | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    const storedToken = localStorage.getItem('auth_token');
    if (storedToken) {
      setToken(storedToken);
      axios.defaults.headers.common['Authorization'] = `Bearer ${storedToken}`;
      // Fetch user data
      fetchUser();
    } else {
      setIsLoading(false);
    }
  }, []);

  const fetchUser = async () => {
    try {
      const response = await axios.get('/api/auth/user');
      setUser(response.data);
      localStorage.setItem('user', JSON.stringify(response.data));
    } catch (error) {
      console.error('Gagal to fetch user:', error);
      logout();
    } finally {
      setIsLoading(false);
    }
  };

  const login = async (email: string, password: string) => {
    try {
      const response = await axios.post('/api/auth/login', { email, password });
      const { access_token } = response.data;
      setToken(access_token);
      localStorage.setItem('auth_token', access_token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
      await fetchUser();
      localStorage.setItem('user', JSON.stringify(user));
      showSuccess('Login Berhasil', 'Selamat datang kembali!');
    } catch (error: any) {
      showError('Login Gagal', error.response?.data?.message || 'Invalid credentials');
      throw error;
    }
  };

  const register = async (name: string, email: string, password: string, role: number) => {
    try {
      const response = await axios.post('/api/auth/register', { name, email, password, password_confirmation: password, role });
      const { access_token } = response.data;
      setToken(access_token);
      localStorage.setItem('auth_token', access_token);
      axios.defaults.headers.common['Authorization'] = `Bearer ${access_token}`;
      await fetchUser();
      localStorage.setItem('user', JSON.stringify(user));
      showSuccess('Registration Berhasil', 'Welcome to EduPath!');
    } catch (error: any) {
      showError('Registration Gagal', error.response?.data?.message || 'Something went wrong');
      throw error;
    }
  };

  const logout = () => {
    setUser(null);
    setToken(null);
    localStorage.removeItem('auth_token');
    localStorage.removeItem('user');
    delete axios.defaults.headers.common['Authorization'];
    showSuccess('Logged Out', 'See you next time!');
  };

  const value: AuthContextType = {
    user,
    token,
    login,
    register,
    logout,
    isLoading,
  };

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
};