import Swal from 'sweetalert2';

export const showSuccess = (title: string, text?: string) => {
  return Swal.fire({
    title,
    text,
    icon: 'success',
    confirmButtonColor: '#22c55e', // green-500
    customClass: {
      popup: 'rounded-lg',
      title: 'text-gray-900 font-bold',
      htmlContainer: 'text-gray-600',
    },
  });
};

export const showError = (title: string, text?: string) => {
  return Swal.fire({
    title,
    text,
    icon: 'error',
    confirmButtonColor: '#ef4444', // red-500
    customClass: {
      popup: 'rounded-lg',
      title: 'text-gray-900 font-bold',
      htmlContainer: 'text-gray-600',
    },
  });
};

export const showConfirm = (title: string, text: string, confirmText = 'Yes', cancelText = 'Cancel') => {
  return Swal.fire({
    title,
    text,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#22c55e',
    cancelButtonColor: '#6b7280',
    confirmButtonText: confirmText,
    cancelButtonText: cancelText,
    customClass: {
      popup: 'rounded-lg',
      title: 'text-gray-900 font-bold',
      htmlContainer: 'text-gray-600',
    },
  });
};