import { useState, useEffect } from "react";
import { useNavigate } from "react-router";
import { Navbar } from "~/components/navbar";
import { Button } from "~/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "~/components/ui/card";
import { Input } from "~/components/ui/input";
import { useAuth } from "~/lib/auth";
import { showError } from "~/lib/swal";

export function meta({}) {
  return [
    { title: "Register - EduPath" },
    { name: "description", content: "Daftar akun baru di EduPath untuk memulai pembelajaran." },
  ];
}

export default function Register() {
  const [name, setName] = useState("");
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [role, setRole] = useState(2); // Default to student (2)
  const [isLoading, setIsLoading] = useState(false);
  const { register, user, isLoading: authLoading } = useAuth();
  const navigate = useNavigate();

  useEffect(() => {
    if (!authLoading && user) {
      if (user.role === 1) {
        navigate("/admin/dashboard");
      } else {
        navigate("/dashboard");
      }
    }
  }, [user, authLoading, navigate]);

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    if (password !== confirmPassword) {
      showError('Password Mismatch', 'Please make sure passwords match');
      return;
    }
    setIsLoading(true);
    try {
      await register(name, email, password, role);
      // Redirect handled by useEffect
    } finally {
      setIsLoading(false);
    }
  };

  if (authLoading) {
    return <div>Loading...</div>;
  }

  if (user) {
    return null; // Will redirect
  }


  return (
    <div className="min-h-screen bg-lime-50  flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
      <Card className="w-full max-w-md">
        <CardHeader className="text-center">
          <CardTitle className="text-2xl font-bold text-edupath-primary">EduPath</CardTitle>
          <CardDescription>
            Buat akun baru untuk memulai perjalanan pembelajaran Anda
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSubmit} className="space-y-6">
            <div>
              <label htmlFor="name" className="block text-sm font-medium text-gray-700">
                Nama Lengkap
              </label>
              <Input
                id="name"
                name="name"
                type="text"
                autoComplete="name"
                required
                className="mt-1"
                placeholder="Masukkan nama lengkap Anda"
                value={name}
                onChange={(e) => setName(e.target.value)}
              />
            </div>
            <div>
              <label htmlFor="email" className="block text-sm font-medium text-gray-700">
                Email
              </label>
              <Input
                id="email"
                name="email"
                type="email"
                autoComplete="email"
                required
                className="mt-1"
                placeholder="Masukkan email Anda"
                value={email}
                onChange={(e) => setEmail(e.target.value)}
              />
            </div>
            <div>
              <label htmlFor="password" className="block text-sm font-medium text-gray-700">
                Password
              </label>
              <Input
                id="password"
                name="password"
                type="password"
                autoComplete="new-password"
                required
                className="mt-1"
                placeholder="Masukkan password Anda"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div>
              <label htmlFor="confirm-password" className="block text-sm font-medium text-gray-700">
                Konfirmasi Password
              </label>
              <Input
                id="confirm-password"
                name="confirm-password"
                type="password"
                autoComplete="new-password"
                required
                className="mt-1"
                placeholder="Konfirmasi password Anda"
                value={confirmPassword}
                onChange={(e) => setConfirmPassword(e.target.value)}
              />
            </div>
            <div>
              <label htmlFor="role" className="block text-sm font-medium text-gray-700">
                Role
              </label>
              <select
                id="role"
                name="role"
                required
                className="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-edupath-primary focus:border-edupath-primary"
                value={role}
                onChange={(e) => setRole(Number(e.target.value))}
              >
                <option value={1}>Admin</option>
                <option value={2}>Student</option>
              </select>
            </div>
            <div>
              <Button type="submit" disabled={isLoading}>
                {isLoading ? "Loading..." : "Daftar"}
              </Button>
            </div>
          </form>
        
          <p className="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?{" "}
            <a href="/login" className="font-medium text-edupath-primary hover:text-edupath-primary/80">
              Masuk sekarang
            </a>
          </p>
        </CardContent>
      </Card>
    </div>
  );
}