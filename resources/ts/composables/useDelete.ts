// 📄 composables/useDelete.ts

import { toast } from 'vue3-toastify';
import axios from 'axios';
import Swal from 'sweetalert2';

export async function useDelete(url: string, id: number, updateList: (id: number) => void) {
  const result = await Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#6b7280',
    confirmButtonText: 'Yes, delete it!',
  });

  if (!result.isConfirmed) return;

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    const response = await axios.delete(url, {
      data: { id },
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
    });

    const data = response.data;

    updateList(id);
    toast.success(data.message || 'Deleted successfully!');
  } catch (error) {
    console.error('Error deleting:', error);
    toast.error('Unexpected error occurred.');
  }
}