import { useState, useEffect } from "react";
import { useNavigate } from "react-router";
import { Navbar } from "~/components/navbar";
import { Button } from "~/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "~/components/ui/card";
import { Input } from "~/components/ui/input";
import { useAuth } from "~/lib/auth";

export function meta({}) {
  return [
    { title: "Login - EduPath" },
    { name: "description", content: "Masuk ke akun EduPath Anda untuk mengakses platform pembelajaran." },
  ];
}

export default function Login() {
  const [email, setEmail] = useState("");
  const [password, setPassword] = useState("");
  const [isLoading, setIsLoading] = useState(false);
  const { login, user, isLoading: authLoading } = useAuth();
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
    setIsLoading(true);
    try {
      await login(email, password);
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
    <div className="min-h-screen bg-lime-50  flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">
      
      <Card className="w-full max-w-md">
        <CardHeader className="text-center">
          <CardTitle className="text-2xl font-bold text-edupath-primary">EduPath</CardTitle>
          <CardDescription>
            Masuk ke akun Anda untuk melanjutkan pembelajaran
          </CardDescription>
        </CardHeader>
        <CardContent>
          <form onSubmit={handleSubmit} className="space-y-6">
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
                autoComplete="current-password"
                required
                className="mt-1"
                placeholder="Masukkan password Anda"
                value={password}
                onChange={(e) => setPassword(e.target.value)}
              />
            </div>
            <div className="flex justify-center items-center">
              <Button type="submit" disabled={isLoading}>
                {isLoading ? "Loading..." : "Masuk"}
              </Button>
            </div>
          </form>
          <p className="mt-6 text-center text-sm text-gray-600">
            Belum punya akun?{" "}
            <a href="/register" className="font-medium text-edupath-primary hover:text-edupath-primary/80">
              Daftar sekarang
            </a>
          </p>
        </CardContent>
      </Card>
    </div>
  );
}