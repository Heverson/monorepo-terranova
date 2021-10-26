import React, { useEffect, useState } from "react";
import { SafeAreaView, ScrollView } from "react-native";
import CarouselBrands from "../../components/CarouselBrands";
import HeaderTitle from "../../components/HeaderTitle";
import { ListProducts } from "../../components/ListProducts";
import { SlideBanner } from "../../components/SlideBanner";
import { api } from "../../services/api";
import { useAuth } from "../../hooks/auth";

import { Container } from "./styles";

interface AxiosProps {
  result: {
    data: [];
    status: string;
  };
}

interface BannersProps {
  imgUrl: string;
  link: string;
}

interface BrandsProps {
  for_id: number;
  for_nome: string;
  for_ordem: number;
  for_categoria: string;
}

const Home: React.FC = () => {
  const { signOut } = useAuth();
  const [banners, setBanners] = useState<BannersProps[]>([]);
  const [brands, setBrands] = useState<BrandsProps[]>([]);

  async function fetchBanners() {
    const { result } = await api("/banners");
    const { data } = result.data;
    setBanners(data);
  }

  async function fetchBrands() {
    const { result } = await api("/brands");
    const { data } = result.data;
    setBrands(brands.data);
  }

  useEffect(() => {
    fetchBanners();
    fetchBrands();
  }, []);

  return (
    <>
      <ScrollView>
        <Container>
          <HeaderTitle>Bien venido Heverson</HeaderTitle>
          <SlideBanner banners={banners} />
          <CarouselBrands />
          <HeaderTitle>Lanzamientos</HeaderTitle>
          <ListProducts column={3} products={banners} />
        </Container>
      </ScrollView>
    </>
  );
};

export default Home;
