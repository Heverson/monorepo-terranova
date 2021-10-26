import useSWR from 'swr';
import axios from 'axios';

export function useFetch(url: string) {
  const {data, error} = useSWR(url, async (url: string) => {
    const {data} = await axios.get(url);
    return data;
  });
  return {data, error};
}
