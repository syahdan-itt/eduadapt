import type { Route } from "./+types/home";
import { Link } from "react-router";
import { Button } from "~/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "~/components/ui/card";
import { Badge } from "~/components/ui/badge";
import { Navbar } from "~/components/navbar";

export function meta({}: Route.MetaArgs) {
  return [
    { title: "EduPath - Platform Pembelajaran Pintar" },
    { name: "description", content: "Platform pembelajaran yang memudahkan siswa dan guru dengan bantuan AI untuk materi, quiz, dan rekomendasi personal." },
  ];
}

export default function Home() {
  return (
    <div className="min-h-screen bg-lime-50">
      <Navbar variant="home" />

      {/* Hero Section */}
      <section className="py-20">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h2 className="text-4xl font-extrabold text-gray-900 sm:text-5xl">
            Belajar Lebih Pintar dengan <span className="text-edupath-primary">EduPath</span>
          </h2>
          <p className="mt-4 text-xl text-gray-500 max-w-3xl mx-auto">
            Platform pembelajaran inovatif yang menggunakan AI untuk membantu siswa menemukan materi yang sesuai dengan gaya belajar mereka, dan guru membuat konten dengan cepat dan efisien.
          </p>
          <div className="mt-8 flex justify-center space-x-4">
            <Link to="/login">
              <Button size="lg">
                Mulai Belajar
              </Button>
            </Link>
            <Button size="lg" variant="outline">
              Pelajari Lebih Lanjut
            </Button>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h3 className="text-3xl font-extrabold text-gray-900">Fitur Unggulan EduPath</h3>
            <p className="mt-4 text-lg text-gray-500">
              Ditenagai oleh AI untuk pengalaman pembelajaran yang personal dan efisien.
            </p>
          </div>
          <div className="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <Badge variant="secondary" className="mr-2">AI</Badge>
                  Rekomendasi Materi
                </CardTitle>
                <CardDescription>
                  AI menganalisis kepribadian pembelajaran siswa untuk merekomendasikan materi berikutnya yang paling sesuai.
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-sm text-gray-600">
                  Tingkatkan efektivitas belajar dengan materi yang disesuaikan dengan cara siswa belajar.
                </p>
              </CardContent>
            </Card>
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <Badge variant="secondary" className="mr-2">AI</Badge>
                  Pembuatan Materi Cepat
                </CardTitle>
                <CardDescription>
                  Guru dapat membuat materi dengan bantuan AI, menghemat waktu dan meningkatkan kualitas.
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-sm text-gray-600">
                  Fokus pada pengajaran, biarkan AI menangani pembuatan konten.
                </p>
              </CardContent>
            </Card>
            <Card>
              <CardHeader>
                <CardTitle className="flex items-center">
                  <Badge variant="secondary" className="mr-2">AI</Badge>
                  Generate Quiz Otomatis
                </CardTitle>
                <CardDescription>
                  Buat quiz dengan mudah menggunakan AI, disesuaikan dengan materi yang diajarkan.
                </CardDescription>
              </CardHeader>
              <CardContent>
                <p className="text-sm text-gray-600">
                  Evaluasi siswa menjadi lebih sederhana dan akurat.
                </p>
              </CardContent>
            </Card>
          </div>
        </div>
      </section>

      {/* For Students Section */}
      <section id="for-students" className="py-16 bg-gray-50">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h3 className="text-3xl font-extrabold text-gray-900">Untuk Siswa</h3>
            <p className="mt-4 text-lg text-gray-500">
              Pengalaman belajar yang dipersonalisasi untuk hasil maksimal.
            </p>
          </div>
          <div className="mt-12">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
              <div>
                <h4 className="text-2xl font-bold text-gray-900">Temukan Materi yang Cocok untuk Anda</h4>
                <p className="mt-4 text-gray-600">
                  Dengan analisis AI terhadap gaya belajar Anda, EduPath merekomendasikan materi berikutnya yang akan membantu Anda belajar lebih efektif. Tidak ada lagi materi yang membosankan atau terlalu sulit.
                </p>
                <ul className="mt-4 space-y-2">
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Analisis kepribadian pembelajaran
                  </li>
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Rekomendasi materi real-time
                  </li>
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Progress tracking yang akurat
                  </li>
                </ul>
              </div>
              <div className="bg-white p-8 rounded-lg shadow-lg">
                <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Student learning" className="w-full h-64 object-cover rounded" />
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* For Teachers Section */}
      <section id="for-teachers" className="py-16 bg-white">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="text-center">
            <h3 className="text-3xl font-extrabold text-gray-900">Untuk Guru</h3>
            <p className="mt-4 text-lg text-gray-500">
              Alat canggih untuk membuat dan mengelola materi dengan mudah.
            </p>
          </div>
          <div className="mt-12">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
              <div className="bg-gray-50 p-8 rounded-lg shadow-lg">
                <img src="https://images.unsplash.com/photo-1583468982228-19f19164aee2?q=80&w=1011&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Teacher creating content" className="w-full h-64 object-cover rounded" />
              </div>
              <div>
                <h4 className="text-2xl font-bold text-gray-900">Buat Materi, Rangkum, dan Quiz dengan AI</h4>
                <p className="mt-4 text-gray-600">
                  EduPath membantu guru membuat materi berkualitas tinggi, merangkum konten kompleks, dan menghasilkan quiz yang relevan dalam hitungan menit.
                </p>
                <ul className="mt-4 space-y-2">
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Pembuatan materi otomatis
                  </li>
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Perangkuman AI yang akurat
                  </li>
                  <li className="flex items-center">
                    <span className="text-green-500 mr-2">✓</span>
                    Generate quiz instan
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-16 bg--primary">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
          <h3 className="text-3xl font-extrabold ">Siap Memulai Perjalanan Pembelajaran Anda?</h3>
          <p className="mt-4 text-xl text-gray-600">
            Bergabunglah dengan ribuan siswa dan guru yang sudah menggunakan EduPath.
          </p>
          <div className="mt-8">
            <Link to="/register">
            <Button size="lg">
              Daftar Gratis Sekarang
            </Button>
            </Link>
          </div>
        </div>
      </section>

      {/* Footer */}
      <footer id="contact" className="bg-footer text-gray-50 py-12">
        <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
              <h4 className="text-lg font-semibold">EduPath</h4>
              <p className="mt-2 text-gray-400">
                Platform pembelajaran masa depan dengan AI.
              </p>
            </div>
            <div>
              <h5 className="text-sm font-semibold uppercase">Produk</h5>
              <ul className="mt-2 space-y-1">
                <li><a href="#" className="text-gray-400 hover:text-white">Untuk Siswa</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Untuk Guru</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Fitur AI</a></li>
              </ul>
            </div>
            <div>
              <h5 className="text-sm font-semibold uppercase">Dukungan</h5>
              <ul className="mt-2 space-y-1">
                <li><a href="#" className="text-gray-400 hover:text-white">Bantuan</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">FAQ</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Kontak</a></li>
              </ul>
            </div>
            <div>
              <h5 className="text-sm font-semibold uppercase">Ikuti Kami</h5>
              <ul className="mt-2 space-y-1">
                <li><a href="#" className="text-gray-400 hover:text-white">Facebook</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">Twitter</a></li>
                <li><a href="#" className="text-gray-400 hover:text-white">LinkedIn</a></li>
              </ul>
            </div>
          </div>
          <div className="mt-8 border-t border-gray-700 pt-8 text-center">
            <p className="text-gray-400">&copy; 2024 EduPath. All rights reserved.</p>
          </div>
        </div>
      </footer>
    </div>
  );
}
