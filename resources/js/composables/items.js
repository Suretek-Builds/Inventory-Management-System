import { Api } from '@/api/api.js'
import axios from "axios";

export default function items() {
  const getItemsList = async () => {
    try {
      const response = await axios.get(`${Api.getItemsList}`);
      const result = response.data;

      if (result.status === 'success') {
        return result.data.list;
      } else {
        throw new Error('Failed to fetch CDT codes: ' + result.message);
      }
    } catch (error) {
      console.error('Error while fetching CDT codes:', error.message || error);
      throw error; // Propagate the error to the caller
    }
  };

  return {
    getItemsList
  }
}
