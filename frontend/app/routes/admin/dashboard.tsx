import { useEffect, useState } from "react";
import { useAuth } from "~/lib/auth";
import { Button } from "~/components/ui/button";
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from "~/components/ui/card";
import { ProtectedRoute } from "~/components/ProtectedRoute";
import axios from "axios";
import { Navbar } from "~/components/navbar";
import { showError } from "~/lib/swal";

interface Subject {
  id: number;
  name: string;
  description: string;
}

export default function AdminDashboard() {
  const { user, logout } = useAuth();
  const [subjects, setSubjects] = useState<Subject[]>([]);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchSubjects = async () => {
      try {
        const response = await axios.get('/api/admin/subject');
        setSubjects(response.data);
      } catch (error) {
        console.error('Failed to fetch subjects:', error);
        showError('Failed to Load Subjects', 'Please try again later');
      } finally {
        setLoading(false);
      }
    };

    if (user?.role === 1) {
      fetchSubjects();
    }
  }, [user]);

  return (
    <ProtectedRoute adminOnly>
      <div className="min-h-screen bg-lime-50">
        <Navbar variant="dashboard" />

      <main className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h2 className="text-3xl font-bold text-gray-900 mb-8">Admin Dashboard</h2>

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          <Card>
            <CardHeader>
              <CardTitle>Manage Subjects</CardTitle>
              <CardDescription>Create and manage subjects</CardDescription>
            </CardHeader>
            <CardContent>
              <Button>Add Subject</Button>
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle>Manage Materials</CardTitle>
              <CardDescription>Oversee learning materials</CardDescription>
            </CardHeader>
            <CardContent>
              <Button>View Materials</Button>
            </CardContent>
          </Card>

          <Card>
            <CardHeader>
              <CardTitle>User Management</CardTitle>
              <CardDescription>Manage users and roles</CardDescription>
            </CardHeader>
            <CardContent>
              <Button>View Users</Button>
            </CardContent>
          </Card>
        </div>

        <section>
          <h3 className="text-2xl font-bold text-gray-900 mb-6">Subjects</h3>
          {loading ? (
            <p>Loading subjects...</p>
          ) : (
            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {subjects.map((subject) => (
                <Card key={subject.id}>
                  <CardHeader>
                    <CardTitle>{subject.name}</CardTitle>
                    <CardDescription>{subject.description}</CardDescription>
                  </CardHeader>
                  <CardContent>
                    <Button>Edit</Button>
                  </CardContent>
                </Card>
              ))}
            </div>
          )}
        </section>
      </main>
    </div>
    </ProtectedRoute>
  );
}