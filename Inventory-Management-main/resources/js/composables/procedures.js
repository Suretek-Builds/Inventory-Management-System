import { Api } from '@/api/api.js';
import axios from 'axios';

export default function procedures() {
  const proceduresList = async (date) => {
    try {
      let params = ''; // Initialize params
      if (date) {
        params = `?date=${date}`; // Correct string interpolation
      }

      const response = await axios.get(`${Api.getProceduresList}${params}`);
      const result = response.data;

      if (result.status === 'success') {
        return result.data.list; // Return the list of procedures
      } else {
        throw new Error(`Failed to fetch Procedure: ${result.message}`);
      }
    } catch (error) {
      console.error('Error while fetching Procedure:', error.message || error);
      throw error; // Propagate the error to the caller
    }
  };

  return {
    proceduresList,
  };
}
