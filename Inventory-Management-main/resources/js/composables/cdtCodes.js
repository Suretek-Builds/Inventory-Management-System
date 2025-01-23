import { Api } from '@/api/api.js'
import axios from "axios";

export default function cdtCodes() {
  const getCdtCodeList = async (type = 'all') => {
    try {
      const response = await axios.get(`${Api.getCdtCodesList}?type=${type}`);
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
    getCdtCodeList
  }
}
