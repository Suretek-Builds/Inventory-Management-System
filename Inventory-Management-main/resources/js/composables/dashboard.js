import { Api } from '@/api/api.js'
import axios from "axios";

export default function dashboard() {
  const getDashboardData = async () => {
    try {
      const response = await axios.post(Api.dashboard)
      const result = response.data;

      if (result.status === 'success') {
        return result.data;
      } else {
        throw new Error('Failed to fetch Dashboard data: ' + result.message);
      }
    } catch (error) {
      console.error('Error while fetching Dashboard data:', error.message || error);
      throw error; // Propagate the error to the caller
    }
  };

  return {
    getDashboardData
  }
}
