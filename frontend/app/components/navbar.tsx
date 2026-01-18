import { Link } from "react-router";
import { Button } from "~/components/ui/button";
import { useAuth } from "~/lib/auth";
import { showConfirm } from "~/lib/swal";

interface NavbarProps {
  variant?: "home" | "dashboard";
  className?: string;
}

export const Navbar = ({ variant = "home", className = "" }: NavbarProps) => {
  const { user, logout } = useAuth();

  const handleLogout = async () => {
    const result = await showConfirm('Logout', 'Are you sure you want to logout?', 'Yes', 'Cancel');
    if (result.isConfirmed) {
      logout();
    }
  };

  if (variant === "dashboard" && user) {
    return (
      <header className="bg-white shadow-sm">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="flex justify-between items-center py-6">
            <Link to="/" className="flex items-center">
              <h1 className="text-2xl font-bold text-edupath-primary">EduPath</h1>
            </Link>
            <div className="flex items-center space-x-4">
              <span>Welcome, {user.name}</span>
              <Button onClick={handleLogout}>Logout</Button>
            </div>
          </div>
        </div>
      </header>
    );
  }

  return (
    <header className={`bg-white shadow-sm ${className}`}>
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between items-center py-6">
          <Link to="/" className="flex items-center">
            <h1 className="text-2xl font-bold text-edupath-primary">EduPath</h1>
          </Link>
          <nav className="hidden md:flex space-x-8">
            <a href="#features" className="text-gray-500 hover:text-gray-900">Fitur</a>
            <a href="#for-students" className="text-gray-500 hover:text-gray-900">Untuk Siswa</a>
            <a href="#for-teachers" className="text-gray-500 hover:text-gray-900">Untuk Guru</a>
            <a href="#contact" className="text-gray-500 hover:text-gray-900">Kontak</a>
          </nav>
          <div className="flex items-center space-x-4">
            {user ? (
              <>
                <span>Welcome, {user.name}</span>
                <Link to={user.role === 1 ? "/admin/dashboard" : "/dashboard"}>
                  <Button >Dashboard</Button>
                </Link>
                {/* <Button onClick={handleLogout}>Logout</Button> */}
              </>
            ) : (
              <>
                <Link to="/login">
                  <Button variant="outline">Masuk</Button>
                </Link>
                <Link to="/register">
                  <Button>Daftar Sekarang</Button>
                </Link>
              </>
            )}
          </div>
        </div>
      </div>
    </header>
  );
};